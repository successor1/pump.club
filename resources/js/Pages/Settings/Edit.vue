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
import {HiSolidChevronDown} from "oh-vue-icons/icons";
import MultiSelect from "@/Components/MultiSelect/MultiSelect.vue";
import VueIcon from "@/Components/VueIcon.vue";
import FormSwitch from "@/Components/FormSwitch.vue";
const props = defineProps({
    title:{required:false,type:String},
    setting:{type:Object,required:true},
});
const form = useForm({
		logo:props.setting.logo,
		name:props.setting.name,
		twitter:props.setting.twitter,
		youtube:props.setting.youtube,
		telegram_group:props.setting.telegram_group,
		telegram_channel:props.setting.telegram_channel,
		discord:props.setting.discord,
		documentation:props.setting.documentation,
		rpc:props.setting.rpc,
		ankr:props.setting.ankr,
		infura:props.setting.infura,
		blast:props.setting.blast,
		chat:props.setting.chat,
		featured:props.setting.featured
});
const save = () => form.put(window.route("admin.settings.update",props.setting.id));
</script>
<template>
    <AdminLayout>
        <Head :title="title ?? `Edit Setting` " />
        <main class="h-full">
            <div class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
                <div class="flex flex-col gap-4 h-full">
                    <div class="lg:flex items-center justify-between mb-4 gap-3">
                        <div class="mb-4 lg:mb-0">
                            <h3 class="h3">Edit Setting</h3>
                        </div>
                        <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                            <PrimaryButton
                                secondary
                                link
								:href="route('admin.settings.index')"
							>
								 <VueIcon :icon="HiArrowLeft" class="w-4 h-4 -ml-1 mr-2 inline-block" />
								{{ $t("Back to settings list") }}</PrimaryButton
							>
                        </div>
                    </div>
                    <div class="card h-full border-0 card-border">
                        <div class="card-body card-gutterless h-full">
                            <form @submit.prevent="save" class="container lg:w-4/5">
                                						         <div>
            <div class="gap-x-3 sm:col-span-2 grid md:grid-cols-2">
        		<FormInput
        			v-model="form.logo_uri"
        			:disabled="form.logo_upload"
        			placeholder="https://"
        			:error="form.errors.logo_uri"
        			:help="$t('Supports png, jpeg or svg')"
        		>
        			<template #label>
        				<div class="flex">
        					<span class="mr-3">{{
        						$t("Logo")
        					}}</span>
        					<label
        						class="inline-flex items-center space-x-2"
        					>
        						<input
        							v-model="form.logo_upload"
        							class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:!bg-emerald-600 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:before:bg-white"
        							type="checkbox"
        						/>
        						<span>{{ $t("Upload to server") }}</span>
        					</label>
        				</div>
        			</template>
        		</FormInput>
        		<template v-if="form.logo_upload">
        			<LogoInput
        				v-if="$page.props.config.s3"
        				v-model="form.logo_uri"
        				v-model:file="form.logo_path"
        				auto
        			/>
        			<LogoInputLocal
        				v-else
        				v-model="form.logo_uri"
        			/>
        		</template>
        		<img
        			v-else
        			class="w-12 h-12 my-auto rounded-full b-0"
        			:src="form.logo_uri ?? fakeLogo"
        		/>
    	    </div>
            <p
				v-if="form.errors.logo"
				class="text-red-500"
			>
				{{ form.errors.logo }}
			</p>
            <p
				v-else
				class="text-xs"
			>
				{{ $t('') }}
			</p>
	    </div>
						 
<FormInput
    :label="Name"
	v-model="form.name"
	class="col-span-3"
    :type="text"
	:error="form.errors.name"
    
    
/>
        
						 
<FormInput
    :label="Twitter"
	v-model="form.twitter"
	class="col-span-3"
    :type="text"
	:error="form.errors.twitter"
    
    
/>
        
						 
<FormInput
    :label="Youtube"
	v-model="form.youtube"
	class="col-span-3"
    :type="text"
	:error="form.errors.youtube"
    
    
/>
        
						 
<FormInput
    :label="Telegram_group"
	v-model="form.telegram_group"
	class="col-span-3"
    :type="text"
	:error="form.errors.telegram_group"
    
    
/>
        
						 
<FormInput
    :label="Telegram_channel"
	v-model="form.telegram_channel"
	class="col-span-3"
    :type="text"
	:error="form.errors.telegram_channel"
    
    
/>
        
						 
<FormInput
    :label="Discord"
	v-model="form.discord"
	class="col-span-3"
    :type="text"
	:error="form.errors.discord"
    
    
/>
        
						 
<FormInput
    :label="Documentation"
	v-model="form.documentation"
	class="col-span-3"
    :type="text"
	:error="form.errors.documentation"
    
    
/>
        
						          <div>
			<FormLabel class="mb-1">{{ $t("Rpc") }}</FormLabel>
			<MultiSelect
				:options="[{key:'ankr', value:'ankr',label:'ankr'},
					{key:'infura', value:'infura',label:'infura'},
					{key:'blast', value:'blast',label:'blast'}]"
				valueProp="value"
				label="label"
				:placeholder="$t('')"
				v-model="rpc"
				searchable
				closeOnSelect
				object
			>
				<template #caret="{isOpen}">
					<VueIcon
						:class="{'rotate-180': isOpen}"
						class="mr-3 relative z-10 opacity-60 flex-shrink-0 flex-grow-0 transition-transform duration-500 w-6 h-6"
						:icon="HiSolidChevronDown"
					/> </template
			></MultiSelect>
		</div>
       
						 
<FormInput
    :label="Ankr"
	v-model="form.ankr"
	class="col-span-3"
    :type="text"
	:error="form.errors.ankr"
    
    
/>
        
						 
<FormInput
    :label="Infura"
	v-model="form.infura"
	class="col-span-3"
    :type="text"
	:error="form.errors.infura"
    
    
/>
        
						 
<FormInput
    :label="Blast"
	v-model="form.blast"
	class="col-span-3"
    :type="text"
	:error="form.errors.blast"
    
    
/>
        
						         <FormSwitch v-model="form.chat">{{$t('Chat')}}</FormSwitch>
						         <FormSwitch v-model="form.featured">{{$t('Featured')}}</FormSwitch>
                                <div class="pt-12">
                                    <div class="flex justify-end">
                                        <PrimaryButton as="button" :href="route('admin.settings.index')"
                                            type="button" link secondary>
                                            {{ $t('Cancel') }}
                                        </PrimaryButton>
                                        <PrimaryButton type="submit" :disabled="form.processing" class="mt-4" primary>
                                            <Loading class="mr-2 -ml-1 inline-block w-5 h-5" v-if="form.processing" />
                                            <span class="text-sm text-white">
                                                {{ $t("Update Setting") }}
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
