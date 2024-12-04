<script setup>
	import { ref } from "vue";

	import { FileCode, Filter } from "lucide-vue-next";

	const holders = ref([
		{
			rank: 1,
			address: "Dsi...5LG",
			percentage: 25.06,
			amount: 250.6,
			value: 17200,
			isContract: true,
		},
		{
			rank: 2,
			address: "A3V...ZA6",
			percentage: 5.31,
			amount: 53.1,
			value: 3651,
			isContract: false,
		},
		{
			rank: 3,
			address: "Hp9...GGb",
			percentage: 4.75,
			amount: 47.5,
			value: 3264,
			isContract: false,
		},
		{
			rank: 3,
			address: "Hp9...GGb",
			percentage: 4.75,
			amount: 47.5,
			value: 3264,
			isContract: false,
		},
		{
			rank: 3,
			address: "Hp9...GGb",
			percentage: 4.75,
			amount: 47.5,
			value: 3264,
			isContract: false,
		},
		{
			rank: 4,
			address: "78m...swS",
			percentage: 4.48,
			amount: 44.8,
			value: 3082,
			isContract: false,
		},
		{
			rank: 5,
			address: "8Qf...MPT",
			percentage: 4.01,
			amount: 40.1,
			value: 2757,
			isContract: false,
		},
		{
			rank: 6,
			address: "CSe...ezT",
			percentage: 2.94,
			amount: 29.4,
			value: 2022,
			isContract: false,
		},
		{
			rank: 7,
			address: "CSN...Lrv",
			percentage: 2.81,
			amount: 28.1,
			value: 1931,
			isContract: false,
		},
		{
			rank: 8,
			address: "DdM...VJF",
			percentage: 2.66,
			amount: 26.6,
			value: 1832,
			isContract: false,
		},
		{
			rank: 9,
			address: "Kp2...R4x",
			percentage: 2.45,
			amount: 24.5,
			value: 1687,
			isContract: false,
		},
		{
			rank: 10,
			address: "Ym7...H9n",
			percentage: 2.31,
			amount: 23.1,
			value: 1590,
			isContract: false,
		},
	]);
</script>
<template>
	<div class="w-fulln text-sm bg-gray-850 rounded-lg overflow-hidden">
		<table class="w-full">
			<thead>
				<tr class="text-left text-gray-400 text-sm">
					<th class="px-6 py-3">RANK</th>
					<th class="px-6 py-3">ADDRESS</th>
					<th class="px-6 py-3">%</th>
					<th class="px-6 py-3">AMOUNT</th>
					<th class="px-6 py-3">VALUE</th>
					<th class="px-6 py-3">TXNS</th>
				</tr>
			</thead>
			<tbody>
				<tr
					v-for="holder in holders"
					:key="holder.rank"
					class="border-t border-gray-750 text-gray-300">
					<td class="px-4 py-2 text-gray-500">#{{ holder.rank }}</td>
					<td class="px-4 py-2 font-mono">
						<div class="flex items-center">
							<a
								class="text-primary hover:text-primary-dark"
								href="#">
								{{ holder.address }}
							</a>
							<FileCode
								v-if="holder.isContract"
								class="w-4 h-4 ml-2 inline-flex" />
						</div>
					</td>
					<td class="px-4 py-2">{{ holder.percentage }}%</td>
					<td class="px-4 py-2 relative">
						<div class="flex items-center">
							<span class="mr-2">{{ holder.amount }}M</span>
							<div class="w-48 bg-gray-700 h-2 rounded-full">
								<div
									class="bg-primary h-2 rounded-full"
									:style="{
										width: `${holder.percentage}%`,
									}"></div>
							</div>
							<span class="ml-2">999.9M</span>
						</div>
					</td>
					<td class="px-4 py-2">
						${{ holder.value.toLocaleString() }}
					</td>
					<td class="px-4 py-2">
						<div class="flex justify-center">
							<Filter class="w-5 h-5 text-gray-500" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>
