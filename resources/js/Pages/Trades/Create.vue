<script setup>
import { HiArrowLeft } from "oh-vue-icons/icons";
import Loading from "@/Components/Loading.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import VueIcon from "@/Components/VueIcon.vue";
import FormInput from "@/Components/FormInput.vue";
import {HiSolidChevronDown} from "oh-vue-icons/icons";
import MultiSelect from "@/Components/MultiSelect/MultiSelect.vue";
import VueIcon from "@/Components/VueIcon.vue";
defineProps({
    title:{required:false,type:String},
});
const form = useForm({
		launchpad_id:"",
		txid:"",
		address:"",
		qty:"",
		amount:"",
		type:""
});
const save = () => form.post(window.route("admin.trades.store"));
</script>
<template>
	<Head :title="title ?? `New Trade`" />
	<AdminLayout>
        <main class="h-full container sm:p-8">
			<div class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
				<div class="flex flex-col gap-4 h-full">
					<div class="lg:flex items-center justify-between mb-4 gap-3">
						<div class="mb-4 lg:mb-0">
							<h3 class="h3">Add New Trade</h3>
						</div>
						<div class="flex flex-col lg:flex-row lg:items-center gap-3">
							<PrimaryButton
                                secondary
                                link
								:href="route('admin.trades.index')"
							>
								
                                <VueIcon :icon="HiArrowLeft" class="w-4 h-4 -ml-1 mr-2 inline-block" />
								{{ $t("Back to trades list") }}</PrimaryButton
							>
						</div>
					</div>
					<div class="card sm:p-12 h-full border-0 card-border">
						<div class="card-body card-gutterless h-full">
							<form
        						class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4"
        						@submit.prevent="save()">
        												 
<FormInput
    :label="Launchpad_id"
	v-model="form.launchpad_id"
	class="col-span-3"
    :type="number"
	:error="form.errors.launchpad_id"
    
    
/>
        

						 
<FormInput
    :label="Address"
	v-model="form.address"
	class="col-span-3"
    :type="text"
	:error="form.errors.address"
    
    
/>
        
						 
<FormInput
    :label="Qty"
	v-model="form.qty"
	class="col-span-3"
    :type="text"
	:error="form.errors.qty"
    
    
/>
        
						 
<FormInput
    :label="Amount"
	v-model="form.amount"
	class="col-span-3"
    :type="text"
	:error="form.errors.amount"
    
    
/>
        
						          <div>
			<FormLabel class="mb-1">{{ $t("Type") }}</FormLabel>
			<MultiSelect
				:options="[{key:'prebond', value:'prebond',label:'Prebond'},
					{key:'buy', value:'buy',label:'Buy'},
					{key:'sell', value:'sell',label:'Sell'}]"
				valueProp="value"
				label="label"
				:placeholder="$t('')"
				v-model="type"
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
       
        						<div class="pt-5 sm:col-span-2 lg:col-span-4">
        							<div class="flex items-center gap-3 justify-end">
        								<PrimaryButton
                                            secondary
        									as="button"
        									:href="route('admin.trades.index')"
        									type="button"
                                            link
                                        >
        									{{ $t("Cancel") }}
        								</PrimaryButton>
        								<PrimaryButton
        									type="submit"
        									:disabled="form.processing"
        									>
        									<Loading
        										class="mr-2 -ml-1 inline-block w-5 h-5"
        										v-if="form.processing" />
        									{{ $t("Save Trade") }}
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
