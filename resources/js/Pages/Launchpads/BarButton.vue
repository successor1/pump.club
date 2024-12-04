<script setup>
	defineProps({
		active: Boolean,
	});
</script>
<template>
	<a class="px-2" href="/solana/dsiwwy2hvknr7y6zi41mhx3dpj5awcpxhyhxeh9tx5lg">
		<div
			:class="
				active
					? 'bg-gray-750 hover:bg-gray-700 '
					: 'bg-transparent hover:bg-gray-750'
			"
			class="flex items-center gap-2 py-1.5 px-3 rounded transition-colors duration-200">
			<span class="text-gray-500 font-bold">#1</span>
			<img
				alt="SMOKINCAT"
				class="block w-4 h-4 rounded-[3px] max-w-[initial]"
				src="https://cdn.dexscreener.com/cms/images/GFl9rzR81_ND5x2m?width=64&amp;height=64&amp;fit=crop&amp;quality=95&amp;format=auto"
				loading="lazy" />
			<span
				class="box-border text-sm font-semibold break-words max-w-32 overflow-hidden text-ellipsis whitespace-nowrap text-transparent bg-clip-text bg-[length:200%] bg-gradient-to-r from-[#ff7700] to-[#f0b90b]">
				SMCT
			</span>
			<div class="flex items-center text-xs font-semibold text-[#f0b90b]">
				<svg
					stroke="currentColor"
					fill="currentColor"
					stroke-width="0"
					viewBox="0 0 448 512"
					focusable="false"
					height="1em"
					width="1em"
					xmlns="http://www.w3.org/2000/svg">
					<path
						d="M349.4 44.6c5.9-13.7 1.5-29.7-10.6-38.5s-28.6-8-39.9 1.8l-256 224c-10 8.8-13.6 22.9-8.9 35.3S50.7 288 64 288H175.5L98.6 467.4c-5.9 13.7-1.5 29.7 10.6 38.5s28.6 8 39.9-1.8l256-224c10-8.8 13.6-22.9 8.9-35.3s-16.6-20.7-30-20.7H272.5L349.4 44.6z"
						class=""></path>
				</svg>
				1600
			</div>
			<span class="text-xs">
				<span class="text-[#a4cf5e]">624%</span>
			</span>
			<div class="text-[#68D391] flex items-center text-xs font-semibold">
				<svg
					stroke="currentColor"
					fill="currentColor"
					stroke-width="0"
					viewBox="0 0 512 512"
					focusable="false"
					height="1em"
					width="1em"
					xmlns="http://www.w3.org/2000/svg">
					<path
						d="M64 96H0c0 123.7 100.3 224 224 224v144c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V320C288 196.3 187.7 96 64 96zm384-64c-84.2 0-157.4 46.5-195.7 115.2 27.7 30.2 48.2 66.9 59 107.6C424 243.1 512 147.9 512 32h-64z"
						class=""></path>
				</svg>
				10h
			</div>
		</div>
	</a>
</template>
