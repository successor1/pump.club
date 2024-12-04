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
const props = defineProps({
    title:{required:false,type:String},
    rate:{type:Object,required:true},
});
const form = useForm({
		symbol:props.rate.symbol,
		chainId:props.rate.chainId,
		usd_rate:props.rate.usd_rate
});
const save = () => form.put(window.route("admin.rates.update",props.rate.id));
</script>
<template>
    <AdminLayout>
        <Head :title="title ?? `Edit Rate` " />
        <main class="h-full">
            <div class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
                <div class="flex flex-col gap-4 h-full">
                    <div class="lg:flex items-center justify-between mb-4 gap-3">
                        <div class="mb-4 lg:mb-0">
                            <h3 class="h3">Edit Rate</h3>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                            <PrimaryButton
                                secondary
                                link
								:href="route('admin.rates.index')"
							>
								 <VueIcon :icon="HiArrowLeft" class="w-4 h-4 -ml-1 mr-2 inline-block" />
								{{ $t("Back to rates list") }}</PrimaryButton
							>
                        </div>
                    </div>
                    <div class="card h-full border-0 card-border">
                        <div class="card-body card-gutterless h-full">
                            <form @submit.prevent="save" class="container lg:w-4/5">
                                						         <div>
            <div class="gap-x-3 sm:col-span-2 grid md:grid-cols-2">
        		<FormInput
        			v-model="form.symbol_uri"
        			:disabled="form.symbol_upload"
        			placeholder="https://"
        			:error="form.errors.symbol_uri"
        			:help="$t('Supports png, jpeg or svg')"
        		>
        			<template #label>
        				<div class="flex">
        					<span class="mr-3">{{
        						$t("Symbol")
        					}}</span>
        					<label
        						class="inline-flex items-center space-x-2"
        					>
        						<input
        							v-model="form.symbol_upload"
        							class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:!bg-emerald-600 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
        							type="checkbox"
        						/>
        						<span>{{ $t("Upload to server") }}</span>
        					</label>
        				</div>
        			</template>
        		</FormInput>
        		<template v-if="form.symbol_upload">
        			<LogoInput
        				v-if="$page.props.config.s3"
        				v-model="form.symbol_uri"
        				v-model:file="form.symbol_path"
        				auto
        			/>
        			<LogoInputLocal
        				v-else
        				v-model="form.symbol_uri"
        			/>
        		</template>
        		<img
        			v-else
        			class="w-12 h-12 my-auto rounded-full b-0"
        			:src="form.symbol_uri ?? fakeLogo"
        		/>
    	    </div>
            <p
				v-if="form.errors.symbol"
				class="text-red-500"
			>
				{{ form.errors.symbol }}
			</p>
            <p
				v-else
				class="text-xs"
			>
				{{ $t('') }}
			</p>
	    </div>
						 
<FormInput
    :label="ChainId"
	v-model="form.chainId"
	class="col-span-3"
    :type="number"
	:error="form.errors.chainId"
    
    
/>
        
						 
<FormInput
    :label="Usd_rate"
	v-model="form.usd_rate"
	class="col-span-3"
    :type="text"
	:error="form.errors.usd_rate"
    
    
/>
        
                                <div class="pt-12">
                                    <div class="flex justify-end">
                                        <PrimaryButton as="button" :href="route('admin.rates.index')"
                                            type="button" link secondary>
                                            {{ $t('Cancel') }}
                                        </PrimaryButton>
                                        <PrimaryButton type="submit" :disabled="form.processing" class="mt-4" primary>
                                            <Loading class="mr-2 -ml-1 inline-block w-5 h-5" v-if="form.processing" />
                                            <span class="text-sm text-white">
                                                {{ $t("Update Rate") }}
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
