<script setup>
import {useI18n} from "vue-i18n";
import { HiArrowLeft } from "oh-vue-icons/icons";
import Loading from "@/Components/Loading.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import VueIcon from "@/Components/VueIcon.vue";
import FormInput from "@/Components/FormInput.vue";
import LogoInput from "@/Components/LogoInput.vue";
import LogoInputLocal from "@/Components/LogoInputLocal.vue";
import fakeLogo from "@/Components/no-image-available-icon.jpeg?url";
import {DatePicker} from "v-calendar";
import {UseTimeAgo} from "@vueuse/components";
import FormLabel from "@/Components/FormLabel.vue";
import FormSwitch from "@/Components/FormSwitch.vue";
const props = defineProps({
    title:{required:false,type:String},
    promo:{type:Object,required:true},
});
const form = useForm({
		name:props.promo.name,
		image:props.promo.image,
		url:props.promo.url,
		starts_at:props.promo.starts_at,
		ends_at:props.promo.ends_at,
		active:props.promo.active
});
const save = () => form.put(window.route("admin.promos.update",props.promo.id));
</script>
<template>
    <AdminLayout>
        <Head :title="title ?? `Edit Promo` " />
        <main class="h-full">
            <div class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
                <div class="flex flex-col gap-4 h-full">
                    <div class="lg:flex items-center justify-between mb-4 gap-3">
                        <div class="mb-4 lg:mb-0">
                            <h3 class="h3">Edit Promo</h3>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                            <PrimaryButton
                                secondary
                                link
								:href="route('admin.promos.index')"
							>
								 <VueIcon :icon="HiArrowLeft" class="w-4 h-4 -ml-1 mr-2 inline-block" />
								{{ $t("Back to promos list") }}</PrimaryButton
							>
                        </div>
                    </div>
                    <div class="card h-full border-0 card-border">
                        <div class="card-body card-gutterless h-full">
                            <form @submit.prevent="save" class="container lg:w-4/5">
                                						 
<FormInput
    :label="Name"
	v-model="form.name"
	class="col-span-3"
    :type="text"
	:error="form.errors.name"
    
    
/>
        
						         <div>
            <div class="gap-x-3 sm:col-span-2 grid md:grid-cols-2">
        		<FormInput
        			v-model="form.image_uri"
        			:disabled="form.image_upload"
        			placeholder="https://"
        			:error="form.errors.image_uri"
        			:help="$t('Supports png, jpeg or svg')"
        		>
        			<template #label>
        				<div class="flex">
        					<span class="mr-3">{{
        						$t("Image")
        					}}</span>
        					<label
        						class="inline-flex items-center space-x-2"
        					>
        						<input
        							v-model="form.image_upload"
        							class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:!bg-emerald-600 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
        							type="checkbox"
        						/>
        						<span>{{ $t("Upload to server") }}</span>
        					</label>
        				</div>
        			</template>
        		</FormInput>
        		<template v-if="form.image_upload">
        			<LogoInput
        				v-if="$page.props.config.s3"
        				v-model="form.image_uri"
        				v-model:file="form.image_path"
        				auto
        			/>
        			<LogoInputLocal
        				v-else
        				v-model="form.image_uri"
        			/>
        		</template>
        		<img
        			v-else
        			class="w-12 h-12 my-auto rounded-full b-0"
        			:src="form.image_uri ?? fakeLogo"
        		/>
    	    </div>
            <p
				v-if="form.errors.image"
				class="text-red-500"
			>
				{{ form.errors.image }}
			</p>
            <p
				v-else
				class="text-xs"
			>
				{{ $t('') }}
			</p>
	    </div>
						 
<FormInput
    :label="Url"
	v-model="form.url"
	class="col-span-3"
    :type="text"
	:error="form.errors.url"
    
    
/>
        
						         <div>
			<FormLabel class="mb-1">{{ $t("Starts_at") }}</FormLabel>
			<DatePicker
				v-model="form.starts_at"
				mode="dateTime"
				is24hr
			>
				<template v-slot="{inputValue, inputEvents}">
					<input
						class="bg-white border-gray-300 text-gray-900 rounded-sm focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white border block w-full focus:outline-none focus:ring-1 appearance-none py-2 text-sm pl-2 pr-2"
						:value="inputValue"
                        
						v-on="inputEvents"
					/>
				</template>
			</DatePicker>
			<p
				v-if="form.errors.starts_at"
				class="text-red-500"
			>
				{{ form.errors.starts_at }}
			</p>
			<UseTimeAgo
				v-else
				v-slot="{timeAgo}"
				:time="form.starts_at"
			>
				<p class="text-sx font-semibold text-emerald-500">
					{{ timeAgo }}
				</p>
			</UseTimeAgo>
		</div>
						         <div>
			<FormLabel class="mb-1">{{ $t("Ends_at") }}</FormLabel>
			<DatePicker
				v-model="form.ends_at"
				mode="dateTime"
				is24hr
			>
				<template v-slot="{inputValue, inputEvents}">
					<input
						class="bg-white border-gray-300 text-gray-900 rounded-sm focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white border block w-full focus:outline-none focus:ring-1 appearance-none py-2 text-sm pl-2 pr-2"
						:value="inputValue"
                        
						v-on="inputEvents"
					/>
				</template>
			</DatePicker>
			<p
				v-if="form.errors.ends_at"
				class="text-red-500"
			>
				{{ form.errors.ends_at }}
			</p>
			<UseTimeAgo
				v-else
				v-slot="{timeAgo}"
				:time="form.ends_at"
			>
				<p class="text-sx font-semibold text-emerald-500">
					{{ timeAgo }}
				</p>
			</UseTimeAgo>
		</div>
						         <FormSwitch v-model="form.active">{{$t('Active')}}</FormSwitch>
                                <div class="pt-12">
                                    <div class="flex justify-end">
                                        <PrimaryButton as="button" :href="route('admin.promos.index')"
                                            type="button" link secondary>
                                            {{ $t('Cancel') }}
                                        </PrimaryButton>
                                        <PrimaryButton type="submit" :disabled="form.processing" class="mt-4" primary>
                                            <Loading class="mr-2 -ml-1 inline-block w-5 h-5" v-if="form.processing" />
                                            <span class="text-sm text-white">
                                                {{ $t("Update Promo") }}
                                            </span>
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AdminLayout>
</template>
