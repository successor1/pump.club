<!-- TokenSidebar.vue -->
<template>
	<div class="bg-gray-900 text-white rounded-lg">
		<!-- Header -->
		<div class="flex items-center gap-2 mb-4">
			<span class="font-semibold">Weird</span>
			<span class="text-gray-400">/</span>
			<span class="font-semibold">WETH</span>
			<span class="bg-green-900 text-green-400 text-xs px-1 rounded">
				1h
			</span>
			<span class="text-orange-500">#10</span>
		</div>

		<!-- Platform Info -->
		<div class="flex items-center gap-2 mb-4">
			<span class="bg-blue-600 rounded-full w-6 h-6"></span>
			<span class="text-gray-400">Base</span>
			<span class="text-gray-400">></span>
			<span class="bg-yellow-400 rounded-full w-6 h-6"></span>
			<span>Moonshot</span>
		</div>

		<!-- Telegram Button -->
		<button
			class="w-full bg-gray-800 text-left px-4 py-2 rounded-lg mb-4 flex justify-between items-center">
			<div class="flex items-center gap-2">
				<span>Telegram</span>
			</div>
			<span>▼</span>
		</button>

		<!-- Progress Bar -->
		<div class="mb-4">
			<div class="flex justify-between mb-2">
				<span class="text-gray-400">Progress:</span>
				<span class="text-green-400">1.0%</span>
			</div>
			<div class="bg-gray-800 rounded-full h-2">
				<div class="bg-green-400 w-[1%] h-full rounded-full"></div>
			</div>
		</div>

		<!-- Price and Market Cap -->
		<div class="grid grid-cols-2 gap-4 mb-4">
			<div class="bg-gray-800 p-4 rounded-lg">
				<div class="text-gray-400 text-sm mb-1">PRICE</div>
				<div class="text-xl font-semibold">$0.05597</div>
			</div>
			<div class="bg-gray-800 p-4 rounded-lg">
				<div class="text-gray-400 text-sm mb-1">MARKET CAP</div>
				<div class="text-xl font-semibold">$5.5K</div>
			</div>
		</div>

		<!-- Time Stats -->
		<div class="grid grid-cols-4 mb-4">
			<div class="text-center">
				<div class="text-gray-400 text-sm">5M</div>
				<div class="text-green-400">0%</div>
			</div>
			<div class="text-center">
				<div class="text-gray-400 text-sm">1H</div>
				<div class="text-red-400">-10.27%</div>
			</div>
			<div class="text-center">
				<div class="text-gray-400 text-sm">6H</div>
				<div class="text-red-400">-1.40%</div>
			</div>
			<div class="text-center">
				<div class="text-gray-400 text-sm">24H</div>
				<div class="text-red-400">-1.40%</div>
			</div>
		</div>

		<!-- Trading Stats -->
		<div class="bg-gray-800 rounded-lg p-4 mb-4">
			<div class="grid grid-cols-3 gap-4 mb-4">
				<div>
					<div class="text-gray-400 text-sm mb-1">TXNS</div>
					<div>10</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">BUYS</div>
					<div>5</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">SELLS</div>
					<div>5</div>
				</div>
			</div>

			<div class="grid grid-cols-3 gap-4 mb-4">
				<div>
					<div class="text-gray-400 text-sm mb-1">VOLUME</div>
					<div>$868</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">BUY VOL</div>
					<div>$438</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">SELL VOL</div>
					<div>$429</div>
				</div>
			</div>

			<div class="grid grid-cols-3 gap-4">
				<div>
					<div class="text-gray-400 text-sm mb-1">MAKERS</div>
					<div>5</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">BUYERS</div>
					<div>5</div>
				</div>
				<div>
					<div class="text-gray-400 text-sm mb-1">SELLERS</div>
					<div>5</div>
				</div>
			</div>
		</div>

		<!-- Alerts Button -->
		<button
			class="w-full bg-gray-800 px-4 py-2 rounded-lg mb-4 flex justify-center items-center gap-2">
			<span>🔔</span>
			<span>Alerts</span>
		</button>

		<!-- Footer Info -->
		<div class="space-y-4 text-sm">
			<div class="flex justify-between items-center">
				<span class="text-gray-400">Token created</span>
				<span>1h 5m ago</span>
			</div>

			<div class="flex justify-between items-center">
				<span class="text-gray-400">Creator</span>
				<div class="flex items-center gap-2">
					<span class="bg-gray-800 px-2 py-1 rounded">
						0x560...bf78
					</span>
					<button class="bg-gray-800 px-2 py-1 rounded">HLD</button>
					<button class="bg-gray-800 px-2 py-1 rounded">EXP</button>
				</div>
			</div>

			<div class="flex justify-between items-center">
				<span class="text-gray-400">Weird</span>
				<div class="flex items-center gap-2">
					<span class="bg-gray-800 px-2 py-1 rounded">
						0xDB9...7BE5
					</span>
					<button class="bg-gray-800 px-2 py-1 rounded">HLD</button>
					<button class="bg-gray-800 px-2 py-1 rounded">EXP</button>
				</div>
			</div>

			<div class="flex justify-between items-center">
				<span class="text-gray-400">Migration DEX</span>
				<span>Uniswap</span>
			</div>
		</div>
	</div>
</template>

<script setup>
	// You can add reactive state and methods here if needed
</script>
