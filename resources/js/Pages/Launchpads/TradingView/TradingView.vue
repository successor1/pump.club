<script setup>
	import { computed, onMounted, onUnmounted, ref, watch } from "vue";

	import { createChart } from "lightweight-charts";

	import PrimaryButton from "@/Components/BaseButton.vue";

	const props = defineProps({
		launchpadId: {
			type: [Number, String],
			required: true,
		},
		symbol: {
			type: String,
			required: true,
		},
	});

	// State
	const chartContainer = ref(null);
	const chart = ref(null);
	const candleSeries = ref(null);
	const volumeSeries = ref(null);
	const loading = ref(true);
	const currentPrice = ref(0);
	const selectedInterval = ref("1h");
	const intervals = ["1m", "5m", "15m", "1h", "4h", "1d"];

	// Computed
	const priceChange = computed(() => {
		// Calculate 24h price change percentage
		return "0.00"; // Implement actual calculation
	});

	const priceChangeColor = computed(() => {
		const change = parseFloat(priceChange.value);
		return change >= 0 ? "text-green-500" : "text-red-500";
	});

	// Methods
	const formatPrice = (price) => {
		return new Intl.NumberFormat("en-US", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 8,
		}).format(price);
	};

	const initChart = () => {
		const options = {
			layout: {
				background: { color: "transparent" },
				textColor: "#D1D5DB",
			},
			grid: {
				vertLines: { color: "#525252" },
				horzLines: { color: "#525252" },
			},
			crosshair: {
				mode: 0,
			},
			rightPriceScale: {
				borderColor: "#525252",
			},
			timeScale: {
				borderColor: "#525252",
				timeVisible: true,
				secondsVisible: false,
			},
		};

		chart.value = createChart(chartContainer.value, options);

		// Create candlestick series
		candleSeries.value = chart.value.addCandlestickSeries({
			upColor: "#10B981",
			downColor: "#EF4444",
			borderVisible: false,
			wickUpColor: "#10B981",
			wickDownColor: "#EF4444",
		});

		// Add volume series
		volumeSeries.value = chart.value.addHistogramSeries({
			color: "#60A5FA",
			priceFormat: {
				type: "volume",
			},
			priceScaleId: "", // Set as an overlay
		});

		// Handle resize
		const handleResize = () => {
			chart.value.applyOptions({
				width: chartContainer.value.clientWidth,
				height: chartContainer.value.clientHeight,
			});
		};

		window.addEventListener("resize", handleResize);

		// Cleanup
		onUnmounted(() => {
			window.removeEventListener("resize", handleResize);
			if (chart.value) {
				chart.value.remove();
			}
		});
	};

	const loadChartData = async () => {
		loading.value = true;
		try {
			const response = await fetch(
				`/api/launchpad/${props.launchpadId}/candles/${selectedInterval.value}`,
			);
			const data = await response.json();

			if (data.candles?.length) {
				candleSeries.value.setData(data.candles);
				volumeSeries.value.setData(data.volumes);
				currentPrice.value =
					data.candles[data.candles.length - 1].close;
			}
		} catch (error) {
			console.error("Error loading chart data:", error);
		} finally {
			loading.value = false;
		}
	};

	const changeInterval = (interval) => {
		selectedInterval.value = interval;
		loadChartData();
	};

	// WebSocket handling
	const handleNewTrade = (trade) => {
		if (trade.launchpad_id !== props.launchpadId) return;

		// Update current candle
		const lastPrice = parseFloat(trade.amount) / parseFloat(trade.qty);
		currentPrice.value = lastPrice;

		// Update chart data
		// This will be implemented based on your backend websocket implementation
	};

	// Lifecycle
	onMounted(() => {
		initChart();
		loadChartData();
		// Subscribe to trade updates
		window.Echo.channel(`launchpad.${props.launchpadId}`).listen(
			"NewTradeEvent",
			handleNewTrade,
		);
	});

	onUnmounted(() => {
		window.Echo.leave(`launchpad.${props.launchpadId}`);
	});

	// Watch for interval changes
	watch(selectedInterval, loadChartData);
</script>
<template>
	<div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg">
		<div class="p-4 border-b dark:border-gray-700">
			<div class="flex items-center justify-between">
				<div class="flex items-center space-x-4">
					<h2 class="text-xl text-primary font-bold">{{ symbol }}</h2>
					<div class="text-sm">
						<span :class="priceChangeColor">
							{{ formatPrice(currentPrice) }}
							({{ priceChange }}%)
						</span>
					</div>
				</div>
				<div class="flex items-center space-x-2">
					<PrimaryButton
						v-for="interval in intervals"
						:key="interval"
						:outlined="selectedInterval !== interval"
						secondary
						size="xss"
						@click="changeInterval(interval)">
						{{ interval }}
					</PrimaryButton>
				</div>
			</div>
		</div>

		<div class="relative">
			<!-- Chart Container -->
			<div ref="chartContainer" class="w-full h-[400px]"></div>

			<!-- Loading Overlay -->
			<div
				v-if="loading"
				class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 flex items-center justify-center">
				<div
					class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
			</div>
		</div>
	</div>
</template>
