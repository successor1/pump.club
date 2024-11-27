<script setup>
	import { onMounted, ref } from "vue";
	import { useAccount, useDisconnect, useSignMessage } from "wagmi";

	import PrimaryButton from "@/Components/PrimaryButton.vue";
	import {
		networks,
		projectId,
		projectName,
		projectUrl,
		wagmiAdapter,
	} from "@/lib/wagmi.js";
	import { createAppKit } from "@reown/appkit/vue";
	import axios from "axios";
	createAppKit({
		adapters: [wagmiAdapter],
		networks,
		projectId,
		metadata: {
			name: projectName,
			description: `${projectName} Crypto Memes Service`,
			url: projectUrl,
		},
	});
	const isAuthenticated = ref(false);
	const { address, isConnected } = useAccount();
	const { openConnectModal } = useConnectModal();
	const { disconnectAsync } = useDisconnect();
	const { signMessageAsync } = useSignMessage();

	const checkAuthStatus = async () => {
		try {
			const response = await axios.get("/api/auth/status");
			isAuthenticated.value = response.data.authenticated;
		} catch (error) {
			console.error("Failed to check auth status:", error);
		}
	};

	const handleConnect = async () => {
		if (!isConnected) {
			openConnectModal();
		}
	};

	const handleVerify = async () => {
		try {
			// Get auth code
			const { data } = await axios.get("/auth/web3/code");
			const authCode = data.authCode;

			// Sign message
			const signature = await signMessageAsync({
				message: authCode,
			});

			// Verify signature and login
			await axios.post("/auth/web3/verify", {
				address: address.value,
				signature,
			});

			isAuthenticated.value = true;
		} catch (error) {
			console.error("Verification failed:", error);
		}
	};

	const handleLogout = async () => {
		try {
			await disconnectAsync();
			await axios.post("/auth/web3/logout");
			isAuthenticated.value = false;
		} catch (error) {
			console.error("Logout failed:", error);
		}
	};

	onMounted(() => {
		checkAuthStatus();
	});
</script>

<template>
	<div class="flex gap-2">
		<template v-if="!isConnected">
			<PrimaryButton @click="handleConnect">Connect Wallet</PrimaryButton>
		</template>

		<template v-else-if="!isAuthenticated">
			<PrimaryButton @click="handleVerify">
				Verify Signature
			</PrimaryButton>
			<PrimaryButton outlined @click="disconnectAsync">
				Disconnect
			</PrimaryButton>
		</template>

		<template v-else>
			<PrimaryButton outlined @click="handleLogout">Logout</PrimaryButton>
		</template>
	</div>
</template>
