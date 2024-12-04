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
		trades: Object,
		title: { required: false, type: String },
	});

	const params = useUrlSearchParams("history");
	const search = ref(params.search ?? "");
	const deleteTradeForm = useForm({});
	const tradeBeingDeleted = ref(null);

	const deleteTrade = () => {
		deleteTradeForm.delete(
			window.route("admin.trades.destroy", tradeBeingDeleted.value?.id),
			{
				preserveScroll: true,
				preserveState: true,
				onSuccess: () => (tradeBeingDeleted.value = null),
			},
		);
	};
	debouncedWatch(
		[search],
		([search]) => {
			router.get(
				window.route("admin.trades.index"),
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

	const toggle = (trade) => {
		trade.busy = true;
		router.put(
			window.route("admin.trades.toggle", trade.id),
			{},
			{
				preserveScroll: true,
				preserveState: true,
				onFinish: () => {
					trade.busy = false;
					tradeBeingDeleted.value = null;
				},
			},
		);
	};
</script>
<template>
	<Head :title="title ?? 'Trades'" />
	<AdminLayout>
		<main class="h-full">
			<div
				class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div
						class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">
								{{ $t("Manage Trades") }}
							</h3>
							<p>{{ $t("Available Trades") }}</p>
						</div>
						<div
							class="flex flex-col lg:flex-row lg:items-center gap-3">
							<PrimaryButton
                                secondary
                                link
								:href="route('admin.trades.create')"
							>
								{{ $t("Create New Trades") }}
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
																					<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Launchpad Id')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Txid')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Address')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Qty')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Amount')}}</th>
									<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{$t('Type')}}</th>
												<td role="columnheader"></td>
											</tr>
										</thead>
										<tbody role="rowgroup">
											<tr
												v-for="trade in trades.data"
												:key="trade.id"
												role="row">
																					<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ trade.launchpad_id }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ trade.txid }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ trade.address }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ trade.qty }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ trade.amount }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" >{{ trade.type }}</td>
												<td role="cell">
													<div
														class="flex justify-end text-lg">
														<Link
															:href="
																route(
																	'admin.trades.edit',
																	trade.id,
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
																tradeBeingDeleted =
																	trade
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
								<Pagination :meta="trades.meta" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<ConfirmationModal
			:show="tradeBeingDeleted"
			@close="tradeBeingDeleted = null">
			<template #title>
				{{
					$t("Are you sure about deleting {trade} ?", {
						trade: tradeBeingDeleted.name,
					})
				}}
			</template>

			<template #content>
				<p>
					{{
						$t(
							"This Action will remove the trade from the database and cannot be undone",
						)
					}}
				</p>
				<p>
					{{
						$t(
							"Its Recommended to Disable the trade Instead",
						)
					}}
				</p>
			</template>

			<template #footer>
				<PrimaryButton
					primary
					class="uppercase text-xs font-semibold"
					@click="tradeBeingDeleted = null">
					{{ $t("Cancel") }}
				</PrimaryButton>

				<PrimaryButton
					secondary
					class="ml-2 uppercase text-xs font-semibold"
					v-if="tradeBeingDeleted.active"
					@click="toggle(tradeBeingDeleted)">
					<Loading v-if="tradeBeingDeleted.busy" />
					{{ $t("Disable") }}
				</PrimaryButton>

				<PrimaryButton
					error
					class="ml-2 uppercase text-xs font-semibold"
					@click="deleteTrade"
					:class="{ 'opacity-25': deleteTradeForm.processing }"
					:disabled="deleteTradeForm.processing">
					{{ $t("Delete") }}
				</PrimaryButton>
			</template>
		</ConfirmationModal>
	</AdminLayout>
</template>
