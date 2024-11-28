<script setup>
	import { computed } from "vue";

	import { router, usePage } from "@inertiajs/vue3";
	import { createAppKit, useAppKit, useDisconnect } from "@reown/appkit/vue";
	import { useAccount, useAccountEffect, useSignMessage } from "@wagmi/vue";
	import axios from "axios";
	import { Power } from "lucide-vue-next";

	import DangerButton from "@/Components/DangerButton.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import SecondaryButton from "@/Components/SecondaryButton.vue";
	import {
		networks,
		projectId,
		projectName,
		projectUrl,
		shortenAddress,
		wagmiAdapter,
	} from "@/lib/wagmi.js";
	createAppKit({
		adapters: [wagmiAdapter],
		networks,
		projectId,
		metadata: {
			name: projectName,
			description: `${projectName} Crypto Memes Service`,
			url: projectUrl,
			icons: [],
		},
	});
	const authCheck = computed(() => !!usePage().props.auth.user);
	const { address, isConnected } = useAccount();
	const { open: openConnectModal } = useAppKit();

	const { disconnect } = useDisconnect();
	const { signMessageAsync } = useSignMessage();

	const handleVerify = async () => {
		try {
			// Get auth code
			const { data } = await axios.post(window.route("auth.code"));
			const authCode = data.authCode;
			// Sign message
			const signature = await signMessageAsync({
				message: authCode,
			});

			// Verify signature and login
			router.post(
				window.route("login"),
				{
					address: address.value,
					signature,
				},
				{
					preserveState: true,
					preserveScroll: true,
				},
			);
		} catch (error) {
			console.error("Verification failed:", error);
		}
	};

	const signOut = async () => {
		if (authCheck.value) await axios.post(window.route("logout"));
	};

	const signIn = async () => {
		if (!authCheck.value) await handleVerify();
	};
	useAccountEffect({
		onConnect(data) {
			signIn();
		},
		onDisconnect() {
			signOut();
		},
	});
</script>

<template>
	<div class="flex gap-2">
		<template v-if="$page.props.auth.user && isConnected">
			<SecondaryButton
				size="xs"
				@click="openConnectModal({ view: 'Account' })"
				outlined>
				{{ shortenAddress(address) }}
			</SecondaryButton>
			<DangerButton size="sm" icon-mode outlined @click="disconnect">
				<Power class="w-4 h-4 stroke-[3]" />
			</DangerButton>
		</template>
		<template v-else-if="isConnected">
			<SecondaryButton size="xs" @click="handleVerify">
				Verify Signature
			</SecondaryButton>
			<DangerButton size="xs" @click="disconnect()">
				Disconnect
			</DangerButton>
		</template>
		<template v-else>
			<PrimaryButton size="xs" outlined @click="openConnectModal">
				Connect Wallet
			</PrimaryButton>
		</template>
	</div>
</template>
