<script setup>
	import { computed, ref, watch } from "vue";

	import { router, usePage } from "@inertiajs/vue3";
	import { createAppKit, useAppKit } from "@reown/appkit/vue";
	import {
		useAccount,
		useAccountEffect,
		useDisconnect,
		useSignMessage,
	} from "@wagmi/vue";
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
		themeVariables: {
			"--w3m-color-mix": "#404040",
			"--w3m-color-mix-strength": 40,
		},
	});
	defineProps({
		size: { type: String, default: "xs" },
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
	const isSigningOut = ref(false);
	const signOut = async () => {
		if (isSigningOut.value) return;
		isSigningOut.value = true;
		if (authCheck.value)
			router.post(
				window.route("logout"),
				{},
				{
					onFinish() {
						isSigningOut.value = false;
					},
				},
			);
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
	watch([isConnected, authCheck], ([isConnected, authCheck]) => {
		if (isConnected && !authCheck) {
			return signIn();
		}
		if (!isConnected && authCheck) {
			return signOut();
		}
	});
</script>

<template>
	<div class="flex gap-2">
		<template v-if="$page.props.auth.user && isConnected">
			<SecondaryButton
				:size="size"
				@click="openConnectModal({ view: 'Account' })"
				outlined>
				{{ shortenAddress(address) }}
			</SecondaryButton>
			<DangerButton size="sm" icon-mode outlined @click="disconnect">
				<Power class="w-4 h-4 stroke-[3]" />
			</DangerButton>
		</template>
		<template v-else-if="isConnected">
			<SecondaryButton :size="size" @click="handleVerify">
				Verify Signature
			</SecondaryButton>
			<DangerButton :size="size" @click="disconnect()">
				Disconnect
			</DangerButton>
		</template>
		<template v-else>
			<PrimaryButton :size="size" outlined @click="openConnectModal">
				Connect Wallet
			</PrimaryButton>
		</template>
	</div>
</template>
