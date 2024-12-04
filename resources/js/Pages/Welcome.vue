<script setup>
	import { Flame, Search } from "lucide-vue-next";

	import BaseButton from "@/Components/BaseButton.vue";
	import FormInput from "@/Components/FormInput.vue";
	import SmallSwitch from "@/Components/SmallSwitch.vue";
	import AppLayout from "@/Layouts/AppLayout.vue";
	import BarButton from "./Launchpads/BarButton.vue";
	import img from "./Launchpads/ce8e405d-8312-4f48-8075-1d5710803f44.jpeg";
	import img2 from "./Launchpads/ea37ddb7-985b-49a5-8fba-a8d7655cf0dc.jpeg";
	import IndexCard from "./Launchpads/IndexCard.vue";
	defineProps({
		canLogin: {
			type: Boolean,
		},
		canRegister: {
			type: Boolean,
		},
		laravelVersion: {
			type: String,
			required: true,
		},
		phpVersion: {
			type: String,
			required: true,
		},
	});

	const testdata = [
		{
			name: "PEPE GRAGRA",
			symbol: "PGR",
			bondingType: "Prebond",
			description: "PEPE",
			marketCap: 56000,
			transactions: 7,
			percentage: 40,
			volume24h: 1,
			age: "1  days",
			contract: "0xbf308b56eab867f87e1168bcc161190d46272c55",
			imageUrl: img,
		},
		{
			name: "Strip Tips",
			symbol: "STS",
			bondingType: "Fair Bonding Curve",
			description:
				"As the world evolves and slowly moves away from cash and more to digital finance, the world's oldest profession will need to evolve as well. Let's be the first to help support them!",
			marketCap: 34000,
			transactions: 15,
			percentage: 10,
			volume24h: 1,
			age: "2  days",
			contract: "0xe0bbbf43f96c501c5fa22e2e8231c1eab288ba71",
			imageUrl: img2,
		},
		{
			name: "Bum's Corner",
			symbol: "$BUMS",
			bondingType: "Prebond",
			description:
				"The $BUMS meme coin is now available on Gra.Fun, combining a unique Telegram game with the promising growth potential of this meme coin. Join now to have fun while getting ahead in the investment game with $BUMS!",
			marketCap: 78564,
			percentage: 80,
			transactions: 0,
			volume24h: 37,
			age: "1  months",
			contract: "0x2437139aaa4838653b24c3846d61e353b3ea8ae4",
			imageUrl: img,
		},
		{
			name: "Christmas",
			symbol: "$CRM",
			bondingType: "Fair Bonding Curve",
			description: "Christmas Memecoin to celebrate the Good News.",
			marketCap: 44670,
			transactions: 8,
			percentage: 24.6,
			volume24h: 4,
			age: "1  days",
			contract: "0x908479039540d250eaba1eb835edcf891ef39947",
			imageUrl: img2,
		},

		{
			name: "SSS",
			symbol: "SSS",
			bondingType: "Fair Bonding Curve",
			description: "This is the biggest festival CCTV mascot in China",
			marketCap: 0,
			transactions: 4,
			percentage: 99,
			volume24h: 983,
			age: "19 hours",
			contract: "0xf2812caf2a4f7d7f6ad6f7e4779c69df41ed9610",
			imageUrl:
				"blob:https://gra.fun/bdc1715c-87ee-446a-a864-b7cbba1612c2",
		},
		{
			name: "BABYGRA",
			symbol: "BABYGRA",
			bondingType: "Classic Bonding Curve",
			description: "BABYGRA NEXT BABYBNB",
			marketCap: 0,
			transactions: 426,
			volume24h: 1,
			age: "2  months",
			contract: "0xcaeb8aac623d53caa97177fd771d232895417f0b",
			imageUrl:
				"blob:https://gra.fun/53f51bbf-6e45-4899-a534-11618301d307",
		},
		{
			name: "isGRAel",
			symbol: "ISGRAEL",
			bondingType: "Classic Bonding Curve",
			description: "dog from Isgrael",
			marketCap: 0,
			transactions: 747,
			volume24h: 4065,
			age: "2  months",
			contract: "0x413d1f0824c1e149f2a8a2986d7c2c3e99638324",
			imageUrl:
				"blob:https://gra.fun/0456cb6d-c209-45b5-8ced-b43c544b7957",
		},
		{
			name: "WAKANDA CATCOIN",
			symbol: "WAKA CAT",
			bondingType: "Prebond",
			description: "One cat million communities",
			marketCap: 0,
			transactions: 24,
			volume24h: 257,
			age: "2  months",
			contract: "0xc636d50f90d27027f10d1555da6094d35d4f0f0f",
			imageUrl:
				"blob:https://gra.fun/75963913-0f93-4fb5-8081-d0fa6480781c",
		},
		{
			name: "Wizzwoods",
			symbol: "WIZZ",
			bondingType: "Fair Bonding Curve",
			description:
				"The WIZZ meme coin, the first pixel farm game integrating interchain capabilities with a unique SocialFi twist, is now available on Gra.Fun. Grab yours now to dive into this exciting farm world and profit with WIZZ!",
			marketCap: 0,
			transactions: 0,
			volume24h: 7,
			age: "1  months",
			contract: "0xd2cf1e14da016f6fa3dba00519a8f6ffd4af6cbd",
			imageUrl:
				"blob:https://gra.fun/cef64217-a3eb-4494-a9c9-403352665998",
		},
		{
			name: "GRAZILLA",
			symbol: "GRAZILLA",
			bondingType: "Classic Bonding Curve",
			description: "No description",
			marketCap: 0,
			transactions: 287,
			volume24h: 55,
			age: "2  months",
			contract: "0x2033212a29c7cc3b6f8e42936de4b839a5402be6",
			imageUrl:
				"blob:https://gra.fun/cbab801f-8686-4b9d-99e0-bbb5ce1adb95",
		},
		{
			name: "HOT",
			symbol: "HOT",
			bondingType: "Classic Bonding Curve",
			description: "HOT coin on the BNB Chain",
			marketCap: 0,
			transactions: 0,
			volume24h: 10,
			age: "2  months",
			contract: "0xbb0355359b71eb560c1c04683d42fc6eb13ec046",
			imageUrl:
				"blob:https://gra.fun/03e7a696-885d-4e52-9d2e-5dd99f109352",
		},
		{
			name: "PandaPump",
			symbol: "PPUMP",
			bondingType: "Classic Bonding Curve",
			description:
				"The fun, community-driven meme token bringing the excitement of growth to the crypto world! Join the Panda family for special events, airdrops, and an ever-rising spirit. Ready to pump?",
			marketCap: 0,
			transactions: 75,
			volume24h: 0,
			age: "2  months",
			contract: "0x4cccce27dabf2c05bab222397065bdff92cc533a",
			imageUrl:
				"blob:https://gra.fun/2fe9722c-ea00-493d-a701-68888c186c2b",
		},
		{
			name: "MyDoge",
			symbol: "MDoge",
			bondingType: "Fair Bonding Curve",
			description:
				"The MyDoge meme coin, linked to the first memecoin wallet, is now available on Gra.Fun. Get yours now to be part of the memecoin wallet revolution and unlock the unique potential of MyDoge!",
			marketCap: 0,
			transactions: 684,
			volume24h: 0,
			age: "1  months",
			contract: "0xef8e9a4534d515389a915324979e588e5eb571df",
			imageUrl:
				"blob:https://gra.fun/135163e3-3028-414a-b49e-4fc7d2b2f763",
		},
		{
			name: "Dogi",
			symbol: "$DOGI",
			bondingType: "Fair Bonding Curve",
			description:
				"The $DOGI meme coin, the first token launched on #DRC20, has now moved to BNBChain and is available on Gra.Fun. This is your chance to own one of the pioneering meme coins with strong growth potential on its new blockchain platform!",
			marketCap: 0,
			transactions: 559,
			volume24h: 0,
			age: "1  months",
			contract: "0x6e67c9e7c7b119a2ebc8bc273437f701fc06e910",
			imageUrl:
				"blob:https://gra.fun/11534fa5-a296-4016-b2dd-d0a4e1ac850a",
		},
	];
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
		<div class="grid my-8">
			<div class="flex flex-col justify-center items-center">
				<h3 class="text-xl font-extralight">
					Discover the next trending meme
				</h3>
				<h3>before everyone else!</h3>
				<div class="flex items-center mt-4 gap-4">
					<BaseButton secondary outlined="">
						How Does it work
					</BaseButton>
					<BaseButton outlined>Launch your token</BaseButton>
				</div>
			</div>
			<div class="flex gap-4 items-center mt-8 flex-wrap">
				<appkit-network-button />
				<BaseButton size="xss" class="font-semibold !px-4 py-1">
					Animation
					<SmallSwitch class="ml-2" />
				</BaseButton>
				<BaseButton size="xs" class="font-semibold !px-4">
					<Flame class="w-4 h-4 mr-1 -ml-1 inline-flex" />
					Trending
				</BaseButton>

				<BaseButton size="xs" secondary class="font-semibold !px-4">
					<Flame class="w-4 h-4 mr-1 -ml-1 inline-flex" />
					Top
				</BaseButton>
				<BaseButton size="xs" secondary class="font-semibold !px-4">
					<Flame class="w-4 h-4 mr-1 -ml-1 inline-flex" />
					Rising
				</BaseButton>
				<BaseButton size="xs" secondary class="font-semibold !px-4">
					<Flame class="w-4 h-4 mr-1 -ml-1 inline-flex" />
					New
				</BaseButton>
				<BaseButton size="xs" secondary class="font-semibold !px-4">
					<Flame class="w-4 h-4 mr-1 -ml-1 inline-flex" />
					Finalized
				</BaseButton>
				<FormInput class="ml-auto max-w-xs w-full" size="sm">
					<template #lead>
						<Search class="w-4 h-4 ml-1 text-gray-400" />
					</template>
				</FormInput>
			</div>
			<div class="grid mt-12 md:grid-col-3 lg:grid-cols-3 gap-5">
				<IndexCard
					v-for="lpd in testdata"
					:key="lpd.name"
					:launchpad="lpd" />
			</div>
		</div>
	</AppLayout>
</template>
