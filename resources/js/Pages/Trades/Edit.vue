<script setup>
import {useI18n} from "vue-i18n";
import { HiArrowLeft } from "oh-vue-icons/icons";
import Loading from "@/Components/Loading.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import VueIcon from "@/Components/VueIcon.vue";
import FormInput from "@/Components/FormInput.vue";
import {HiSolidChevronDown} from "oh-vue-icons/icons";
import MultiSelect from "@/Components/MultiSelect/MultiSelect.vue";
import VueIcon from "@/Components/VueIcon.vue";
const props = defineProps({
    title:{required:false,type:String},
    trade:{type:Object,required:true},
});
const form = useForm({
		launchpad_id:props.trade.launchpad_id,
		txid:props.trade.txid,
		address:props.trade.address,
		qty:props.trade.qty,
		amount:props.trade.amount,
		type:props.trade.type
});
const save = () => form.put(window.route("admin.trades.update",props.trade.id));
</script>
<template>
    <AdminLayout>
        <Head :title="title ?? `Edit Trade` " />
        <main class="h-full">
            <div class="relative h-full flex flex-auto flex-col px-4 sm:px-6 py-12 sm:py-6 md:px-8">
                <div class="flex flex-col gap-4 h-full">
                    <div class="lg:flex items-center justify-between mb-4 gap-3">
                        <div class="mb-4 lg:mb-0">
                            <h3 class="h3">Edit Trade</h3>
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
                    <div class="card h-full border-0 card-border">
                        <div class="card-body card-gutterless h-full">
                            <form @submit.prevent="save" class="container lg:w-4/5">
                                						 
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
       
                                <div class="pt-12">
                                    <div class="flex justify-end">
                                        <PrimaryButton as="button" :href="route('admin.trades.index')"
                                            type="button" link secondary>
                                            {{ $t('Cancel') }}
                                        </PrimaryButton>
                                        <PrimaryButton type="submit" :disabled="form.processing" class="mt-4" primary>
                                            <Loading class="mr-2 -ml-1 inline-block w-5 h-5" v-if="form.processing" />
                                            <span class="text-sm text-white">
                                                {{ $t("Update Trade") }}
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
