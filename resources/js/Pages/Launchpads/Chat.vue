<!-- LaunchpadChat.vue -->
<script setup>
	import { nextTick, onMounted, ref, watch } from "vue";

	import { PaperAirplaneIcon } from "@heroicons/vue/24/outline";
	import { useForm } from "@inertiajs/vue3";

	import BaseButton from "@/Components/BaseButton.vue";
	import FormInput from "@/Components/FormInput.vue";

	const props = defineProps({
		launchpadId: {
			type: Number,
			required: true,
		},
		initialMessages: {
			type: Array,
			default: () => [],
		},
	});

	const messages = ref([
		{
			uuid: "msg-001",
			user_id: 1, // Current user
			message:
				"Hey everyone! Just joined the chat. Looking forward to connecting with you all! 👋",
			user: {
				id: 1,
				name: "John Doe",
				profile_photo_url:
					"https://randomuser.me/api/portraits/men/1.jpg",
				address: "0x1234567890abcdef",
			},
		},
		{
			uuid: "msg-002",
			user_id: 2,
			message:
				"Welcome John! Great to have you here. How did you find out about our community?",
			user: {
				id: 2,
				name: "Alice Smith",
				profile_photo_url:
					"https://randomuser.me/api/portraits/women/1.jpg",
				address: "0xabcdef1234567890",
			},
		},
		{
			uuid: "msg-003",
			user_id: 1,
			message:
				"Thanks Alice! I heard about it through the blockchain conference last week. By the way, check out this cool NFT I just minted:",
			image: "/api/placeholder/400/300",
			user: {
				id: 1,
				name: "John Doe",
				profile_photo_url:
					"https://randomuser.me/api/portraits/men/1.jpg",
				address: "0x1234567890abcdef",
			},
		},
		{
			uuid: "msg-004",
			user_id: 3,
			message: "That's an impressive piece! The detail in it is amazing.",
			user: {
				id: 3,
				name: null,
				profile_photo_url:
					"https://randomuser.me/api/portraits/men/2.jpg",
				address: "0x9876543210fedcba",
			},
		},
		{
			uuid: "msg-005",
			user_id: 1,
			message:
				"Appreciate it! I've been working on improving my digital art skills.",
			user: {
				id: 1,
				name: "John Doe",
				profile_photo_url:
					"https://randomuser.me/api/portraits/men/1.jpg",
				address: "0x1234567890abcdef",
			},
		},
		{
			uuid: "msg-006",
			user_id: 4,
			message:
				"Hello everyone! Just dropping by to share our latest community update:",
			image: "/api/placeholder/600/400",
			user: {
				id: 4,
				name: "Emma Wilson",
				profile_photo_url:
					"https://randomuser.me/api/portraits/women/2.jpg",
				address: "0xfedc123456789abc",
			},
		},
		{
			uuid: "msg-007",
			user_id: 2,
			message:
				"Thanks for sharing, Emma! The new features look promising.",
			user: {
				id: 2,
				name: "Alice Smith",
				profile_photo_url:
					"https://randomuser.me/api/portraits/women/1.jpg",
				address: "0xabcdef1234567890",
			},
		},
		{
			uuid: "msg-008",
			user_id: 1,
			message:
				"Agreed! Can't wait to try them out. Quick question - when is the next community call?",
			user: {
				id: 1,
				name: "John Doe",
				profile_photo_url:
					"https://randomuser.me/api/portraits/men/1.jpg",
				address: "0x1234567890abcdef",
			},
		},
		{
			uuid: "msg-009",
			user_id: 4,
			message:
				"It's scheduled for next Tuesday at 2 PM UTC. I'll send out the calendar invites shortly!",
			user: {
				id: 4,
				name: "Emma Wilson",
				profile_photo_url:
					"https://randomuser.me/api/portraits/women/2.jpg",
				address: "0xfedc123456789abc",
			},
		},
		{
			uuid: "msg-010",
			user_id: 1,
			message:
				"Perfect, thanks! Added it to my calendar. See you all there! 📅",
			user: {
				id: 1,
				name: "John Doe",
				profile_photo_url:
					"https://randomuser.me/api/portraits/men/1.jpg",
				address: "0x1234567890abcdef",
			},
		},
	]);
	const imagePreview = ref(null);
	const uploadPath = ref(null);

	const form = useForm({
		message: "",
		image_path: null,
		image_upload: false,
		launchpad_id: props.launchpadId,
	});

	// Websocket connection
	onMounted(() => {
		window.Echo.channel(`launchpad.${props.launchpadId}`).listen(
			"NewMessage",
			(e) => {
				messages.value.push(e.message);
				scrollToBottom();
			},
		);
	});

	const scrollToBottom = () => {
		nextTick(() => {
			const container = document.querySelector(".messages-container");
			if (container) {
				container.scrollTop = container.scrollHeight;
			}
		});
	};

	const submitMessage = () => {
		if (!form.message && !form.image_path) return;

		form.post(window.route("msgs.store"), {
			preserveScroll: true,
			onSuccess: () => {
				form.reset();
				imagePreview.value = null;
				uploadPath.value = null;
			},
		});
	};

	const removeImage = () => {
		form.image_path = null;
		form.image_upload = false;
		imagePreview.value = null;
		uploadPath.value = null;
	};

	watch(
		messages,
		() => {
			scrollToBottom();
		},
		{ deep: true },
	);
</script>

<template>
	<div class="flex flex-col h-[500px] rounded-lg shadow">
		<!-- Messages Container -->
		<div class="flex-1 overflow-y-auto pb-4 messages-container">
			<div
				v-for="message in messages"
				:key="message.uuid"
				class="mb-4"
				:class="{
					'flex justify-end':
						message.user_id === $page.props.auth.user?.id,
				}">
				<div
					:class="{
						'bg-blue-100 dark:bg-blue-900':
							message.user_id === $page.props.auth.user?.id,
						'bg-gray-100 dark:bg-gray-750':
							message.user_id !== $page.props.auth.user?.id,
					}"
					class="rounded-lg p-3">
					<div class="flex items-start">
						<img
							:src="message.user.profile_photo_url"
							:alt="message.user.name"
							class="w-8 h-8 rounded-full mr-2" />
						<div>
							<div class="text-sm font-semibold mb-1">
								{{
									message.user.name ||
									message.user.address.substring(0, 6)
								}}
							</div>
							<p class="text-sm">{{ message.message }}</p>
							<img
								v-if="message.image"
								:src="message.image"
								class="mt-2 rounded-lg max-w-full h-auto"
								@click="$emit('image-click', message.image)" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Input Area -->
		<div class="pt-4">
			<form @submit.prevent="submitMessage" class="space-y-4">
				<!-- Image Preview -->
				<div class="flex items-center space-x-4">
					<div class="flex-1">
						<FormInput
							v-model="form.message"
							type="text"
							size="md"
							placeholder="Type your message..."></FormInput>
					</div>
					<BaseButton>
						<PaperAirplaneIcon class="w-6 h-6" />
					</BaseButton>
				</div>
			</form>
		</div>
	</div>
</template>
