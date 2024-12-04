<script setup>
	import { ref } from "vue";

	import { MessageSquare, TvMinimalPlay, UsersRound } from "lucide-vue-next";
	import { RiExchangeLine } from "oh-vue-icons/icons";

	import BaseButton from "@/Components/BaseButton.vue";
	import VueIcon from "@/Components/VueIcon.vue";
	import AppLayout from "@/Layouts/AppLayout.vue";
	import BarButton from "@/Pages/Launchpads/BarButton.vue";
	import Chat from "@/Pages/Launchpads/Chat.vue";
	import BuyCard from "@/Pages/Launchpads/TradingView/BuyCard.vue";
	import DevStream from "@/Pages/Launchpads/TradingView/DevStream.vue";
	import Holders from "@/Pages/Launchpads/TradingView/Holders.vue";
	import Info from "@/Pages/Launchpads/TradingView/Info.vue";
	import Trades from "@/Pages/Launchpads/TradingView/Trades.vue";
	import TradingView from "@/Pages/Launchpads/TradingView/TradingView.vue";
	import LockCard from "./TradingView/LockCard.vue";

	defineProps({
		launchpad: Object,
		tops: Array,
	});

	const tabs = [
		{ name: "Chat", icon: MessageSquare },
		{ name: "Trades", icon: RiExchangeLine, vueicon: true },
		{ name: "Holders", icon: UsersRound },
		{ name: "Dev Stream", icon: TvMinimalPlay },
	];
	const activeTab = ref("Chat");
</script>
<template>
	<AppLayout compact>
		<template #header>
			<div
				class="flex items-center w-full bg-gray-850 h-12 relative overflow-x-hidden">
				<div
					class="flex w-full items-center overflow-x-auto [scrollbar-width:none]">
					<div class="flex w-full items-center">
						<BarButton active />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
						<BarButton />
					</div>
				</div>
				<div
					class="h-12 w-20 absolute right-0 pointer-events-none bg-gradient-to-r from-transparent via-gray-850/50 to-gray-850"></div>
			</div>
		</template>
		<div class="flex space-x-8 mt-4 justify-center">
			<div class="flex flex-col gap-2 w-2/3">
				<div class="h-4/8">
					<TradingView
						:launchpad-id="launchpad.id"
						:symbol="launchpad.symbol" />
				</div>
				<div class="flex gap-2 h-fit mt-6">
					<BaseButton
						v-for="tab in tabs"
						:key="tab.name"
						:outlined="tab.name != activeTab"
						@click="activeTab = tab.name"
						size="xs">
						<VueIcon
							:icon="RiExchangeLine"
							v-if="tab.vueicon"
							class="w-4 h-4 mr-1 -ml-1 inline-flex" />
						<component
							v-else
							class="w-4 h-4 mr-1 -ml-1 inline-flex"
							:is="tab.icon" />

						{{ tab.name }}
					</BaseButton>
				</div>

				<div class="text-gray-300 mt-4 grid gap-1 relative h-[540px]">
					<div
						v-if="activeTab == 'Chat'"
						class="flex flex:col md:flex-row items-center">
						<Chat class="md:w-full" />
					</div>
					<Trades v-if="activeTab == 'Trades'" />
					<Holders v-if="activeTab == 'Holders'" />
					<DevStream v-if="activeTab == 'Dev Stream'" />
				</div>
			</div>
			<div class="grid mb-12 gap-4 h-fit w-fit mx-auto">
				<BuyCard :launchpad="launchpad" />
				<LockCard :launchpad="launchpad" />
				<Info />
			</div>
		</div>
	</AppLayout>
</template>
