<script setup>
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Loading from "@/Components/Loading.vue";
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SearchInput from "@/Components/SearchInput.vue";
import VueIcon from "@/Components/VueIcon.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, router, useForm } from "@inertiajs/vue3";
import { debouncedWatch, useUrlSearchParams } from "@vueuse/core";
import { HiPencil, HiTrash } from "oh-vue-icons/icons";
import { ref } from "vue";
	defineProps({
		promos: Object,
		title: { required: false, type: String },
	});

	const params = useUrlSearchParams("history");
	const search = ref(params.search ?? "");
	const deletePromoForm = useForm({});
	const promoBeingDeleted = ref(null);

	const deletePromo = () => {
		deletePromoForm.delete(
			window.route("admin.promos.destroy", promoBeingDeleted.value?.id),
			{
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => (promoBeingDeleted.value = null),
			},
		);
	};
	debouncedWatch(
		[search],
		([search]) => {
			router.get(
				window.route("admin.promos.index"),
				{ search },
				{
					preserveState: true,
					preserveScroll: true,
				},
			);
		},
		{
			maxWait: 700,
		},
	);

	const toggle = (promo) => {
		promo.busy = true;
		router.put(
			window.route("admin.promos.toggle", promo.id),
			{},
			{
				preserveScroll: true,
				preserveState: true,
				onFinish: () => {
					promo.busy = false;
					promoBeingDeleted.value = null;
				},
			},
		);
	};
</script>
<template>
	<Head :title="title ?? 'Promos'" />
	<AdminLayout>
		<main class="h-full">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">
								{{ $t("Manage Promos") }}
							</h3>
							<p>{{ $t("Available Promos") }}</p>
						</div>
						<div
							class="flex flex-col lg:flex-row lg:items-center gap-3">
							<PrimaryButton
                                secondary
                                link
								:href="route('admin.promos.create')"
							>
								{{ $t("Create New Promos") }}
							</PrimaryButton>
						</div>
					</div>
					<div class="card border-0 card-border">
						<div class="card-body card-gutterless h-full">
							<div
								class="lg:flex items-center justify-end mb-4 px-6">
								<div class="flex gap-x-3 sm:w-1/2 lg:w-1/4">
									<SearchInput
										class="max-w-md"
										v-model="search" />
								</div>
							</div>
							<div>
								<div class="overflow-x-auto">
									<table
										class="table-default table-hover"
										role="table">
										<thead>
											<tr role="row">
																					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Name')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Image')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Url')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Starts At')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Ends At')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Active')}}</th>
												<td role="columnheader"></td>
											</tr>
										</thead>
										<tbody role="rowgroup">
											<tr
												v-for="promo in promos.data"
												:key="promo.id"
												role="row">
																					<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ promo.name }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ promo.image }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ promo.url }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ promo.starts_at }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ promo.ends_at }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ promo.active }}</td>
												<td role="cell">
													<div
														class="flex justify-end text-lg">
														<Link
															:href="
																route(
																	'admin.promos.edit',
																	promo.id,
																)
															"
															class="cursor-pointer p-2 hover:text-blue-600">
															<VueIcon
																:icon="HiPencil"
																class="w-4 h-4" />
														</Link>
														<a
															href="#"
															@click.prevent="
																promoBeingDeleted =
																	promo
															"
															class="cursor-pointer p-2 hover:text-red-500">
															<VueIcon
																:icon="HiTrash"
																class="w-4 h-4" />
														</a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<Pagination :meta="promos.meta" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<ConfirmationModal
			:show="promoBeingDeleted"
			@close="promoBeingDeleted = null">
			<template #title>
				{{
					$t("Are you sure about deleting {promo} ?", {
						promo: promoBeingDeleted.name,
					})
				}}
			</template>

			<template #content>
				<p>
					{{
						$t(
							"This Action will remove the promo from the database and cannot be undone",
						)
					}}
				</p>
				<p>
					{{
						$t(
							"Its Recommended to Disable the promo Instead",
						)
					}}
				</p>
			</template>

			<template #footer>
				<PrimaryButton
					primary
					class="uppercase text-xs font-semibold"
					@click="promoBeingDeleted = null">
					{{ $t("Cancel") }}
				</PrimaryButton>

				<PrimaryButton
					secondary
					class="ml-2 uppercase text-xs font-semibold"
					v-if="promoBeingDeleted.active"
					@click="toggle(promoBeingDeleted)">
					<Loading v-if="promoBeingDeleted.busy" />
					{{ $t("Disable") }}
				</PrimaryButton>

				<PrimaryButton
					error
					class="ml-2 uppercase text-xs font-semibold"
					@click="deletePromo"
					:class="{ 'opacity-25': deletePromoForm.processing }"
					:disabled="deletePromoForm.processing">
					{{ $t("Delete") }}
				</PrimaryButton>
			</template>
		</ConfirmationModal>
	</AdminLayout>
</template>
