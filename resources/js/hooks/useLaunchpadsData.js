import { ref, watch } from "vue";


import { get } from "@vueuse/core";
import { getPublicClient } from '@wagmi/core';
import { useConfig } from "@wagmi/vue";
import { formatEther } from "viem";

import { multicall } from "./multicall";
export const useLaunchpadsData = (launchpads, rates) => {
    const stakes = ref([...get(launchpads)]);
    const loading = ref(false);
    const client = getPublicClient(useConfig());
    const update = async () => {
        stakes.value = [];
        loading.value = true;
        const calls = get(launchpads).map(s => {
            return {
                ...s,
                contract: { abi: s.factory.abi, address: s.contract },
                currentPhase: { functionName: 'currentPhase', args: [] },
                isFinalized: { functionName: 'isFinalized', args: [] },
                totalETHCollected: { functionName: 'totalETHCollected', args: [] },
                getBondingCurveSettings: { functionName: 'getBondingCurveSettings', args: [] }
            };
        });
        const [results] = await multicall([calls], { client }).catch(e => {
            console.log(e);
            return [];
        });
        console.log(results);
        stakes.value = results.map(r => {
            const rate = rates[r.chainId] ?? 1;
            const totalETHCollected = formatEther(r.totalETHCollected);
            const targetEther = formatEther(r.getBondingCurveSettings.bondingTarget);
            return {
                ...r,
                status: r.currentPhase === 0 ? 'prebond' : r.currentPhase === 1 ? 'bonding' : 'finalized',
                totalETHCollected,
                targetEther,
                marketCap: (totalETHCollected * 2 * rate).toFixed(6) * 1,
                percentage: (totalETHCollected / targetEther * 100).toFixed(2) * 1
            };
        });
        loading.value = false;
        return stakes.value;
    };
    watch(launchpads, update, { immediate: true });
    return {
        launchpads: stakes,
        update,
        loading
    };
};