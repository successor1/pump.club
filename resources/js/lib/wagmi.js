/* eslint-disable import/order */
import { WagmiAdapter } from '@reown/appkit-adapter-wagmi';
import { arbitrum, bsc, sepolia } from '@reown/appkit/networks';
import { fallback, http, webSocket } from '@wagmi/vue';
import { createClient } from 'viem';
export const networks = [arbitrum, bsc, sepolia];
export const projectId = import.meta.env.VITE_PROJECT_ID;
export const projectUrl = import.meta.env.VITE_PROJECT_URL;
export const projectName = import.meta.env.VITE_PROJECT_APP_NAME;
export const wagmiAdapter = new WagmiAdapter({
    networks,
    multiInjectedProviderDiscovery: true,
    autoConnect: true,
    client({ chain }) {
        const ankr = ankrApi(chain);
        return createClient({
            chain,
            transport: fallback([
                http(ankr?.http),
                webSocket(ankr?.webSocket),
                http(),
            ])
        });
    },
});


export const ankrApi = (chain) => {
    const ANKR_KEY = import.meta.env.VITE_ANKR_KEY;
    const chainNames = {
        [bsc.id]: 'bsc',
        [sepolia.id]: 'eth_sepolia',
        [arbitrum.id]: 'arbitrum'
    };
    const path = chainNames[chain.id] ?? null;
    if (!path) return null;
    return {
        http: `https://rpc.ankr.com/${path}/${ANKR_KEY}`,
        webSocket: `wss://rpc.ankr.com/${path}/ws/${ANKR_KEY}`
    };
};


export function shortenAddress(address, chars = 4) {
    if (!address) return null;
    if (address?.length <= chars) return address;
    return `${address.substring(0, chars + 2)}...${address.substring(
        42 - chars,
    )}`;
}
// shorten the checksummed version of the input address to have 0x + 4 characters at start and end

export function truncateTx(fullStr = "", strLen = 33, separator = "...") {
    if (fullStr?.length <= strLen) return fullStr;
    const sepLen = separator.length;
    const charsToShow = strLen - sepLen;
    const frontChars = Math.ceil(charsToShow / 2);
    const backChars = Math.floor(charsToShow / 2);
    return (
        fullStr.substring(0, frontChars + 3) +
        separator +
        fullStr.substring(fullStr.length - backChars - 3)
    );
}
