<script setup>
	import { onMounted, onUnmounted, ref } from "vue";

	import { usePage } from "@inertiajs/vue3";

	import Pagination from "@/Components/Pagination.vue";
	defineProps({
		trades: Object,
	});
	const page = usePage();
	const launchpad = page.props.launchpad;
	const recentTrades = ref([
		{
			id: 1,
			created_at: "2024-12-02T09:30:00Z",
			type: "prebond",
			amount: "5243.75",
			qty: "1.25",
			// Price would be calculated as 4195 (amount/qty)
		},
		{
			id: 1,
			created_at: "2024-12-02T09:30:00Z",
			type: "prebond",
			amount: "5243.75",
			qty: "1.25",
			// Price would be calculated as 4195 (amount/qty)
		},

		{
			id: 2,
			created_at: "2024-12-02T09:28:15Z",
			type: "sell",
			amount: "16805.20",
			qty: "4.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 2,
			created_at: "2024-12-02T09:28:15Z",
			type: "prebond",
			amount: "16805.20",
			qty: "4.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 3,
			created_at: "2024-12-02T09:25:30Z",
			type: "buy",
			amount: "2100.65",
			qty: "0.50",
			// Price would be calculated as 4201.30
		},
		{
			id: 4,
			created_at: "2024-12-02T09:20:45Z",
			type: "sell",
			amount: "42013.00",
			qty: "10.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 5,
			created_at: "2024-12-02T09:15:00Z",
			type: "buy",
			amount: "8402.60",
			qty: "2.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 6,
			created_at: "2024-12-02T09:10:30Z",
			type: "sell",
			amount: "12603.90",
			qty: "3.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 7,
			created_at: "2024-12-02T09:05:15Z",
			type: "buy",
			amount: "21006.50",
			qty: "5.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 8,
			created_at: "2024-12-02T09:00:00Z",
			type: "sell",
			amount: "6301.95",
			qty: "1.50",
			// Price would be calculated as 4201.30
		},
		{
			id: 9,
			created_at: "2024-12-01T23:55:00Z",
			type: "buy",
			amount: "4201.30",
			qty: "1.00",
			// Price would be calculated as 4201.30
		},
		{
			id: 10,
			created_at: "2024-12-01T23:50:00Z",
			type: "sell",
			amount: "25207.80",
			qty: "6.00",
			// Price would be calculated as 4201.30
		},
	]);

	// Methods
	const formatDate = (date) => {
		return new Date(date).toLocaleString();
	};

	const formatNumber = (number) => {
		return new Intl.NumberFormat("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 8,
		}).format(number);
	};

	const formatPrice = (price) => {
		return new Intl.NumberFormat("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 8,
		}).format(price);
	};

	const loadRecentTrades = async () => {
		try {
			const response = await fetch(
				`/api/launchpad/${launchpad.id}/trades`,
			);
			const data = await response.json();
			// recentTrades.value = data.trades;
		} catch (error) {
			console.error("Error loading recent trades:", error);
		}
	};

	// WebSocket handling
	const handleNewTrade = (trade) => {
		recentTrades.value.unshift(trade);
		if (recentTrades.value.length > 50) {
			recentTrades.value.pop();
		}
	};

	// Lifecycle
	onMounted(() => {
		loadRecentTrades();

		window.Echo.channel(`launchpad.${launchpad.id}`).listen(
			"NewTradeEvent",
			handleNewTrade,
		);
	});

	onUnmounted(() => {
		window.Echo.leave(`launchpad.${launchpad.id}`);
	});
</script>

<template>
	<div class="border border-gray-200 dark:border-gray-700">
		<div class="">
			<table
				class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
				<thead>
					<tr>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Time
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Type
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Price
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Amount
						</th>
						<th
							class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
							Total
						</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					<tr
						v-for="trade in recentTrades"
						:key="trade.id"
						:class="
							trade.type === 'prebond'
								? 'text-gray-300'
								: trade.type === 'buy'
								? 'text-emerald-400'
								: 'text-red-400'
						"
						class="text-sm">
						<td class="px-4 py-2 whitespace-nowrap">
							{{ formatDate(trade.created_at) }}
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							<span
								class="px-2 inline-flex text-xs uppercase leading-5 font-semibold rounded-full">
								{{ trade.type }}
							</span>
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							{{
								formatPrice(
									parseFloat(trade.amount) /
										parseFloat(trade.qty),
								)
							}}
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							{{ formatNumber(trade.qty) }}
						</td>
						<td class="px-4 py-2 whitespace-nowrap">
							{{ formatNumber(trade.amount) }}
						</td>
					</tr>
				</tbody>
			</table>
			<Pagination v-if="trades?.meta" :meta="trades.meta" />
		</div>
	</div>
</template>
