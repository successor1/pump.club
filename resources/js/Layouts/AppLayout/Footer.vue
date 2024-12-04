<script setup>
	import { Link } from "@inertiajs/vue3";
	import { BookOpenCheckIcon, LucideSend } from "lucide-vue-next";
	import { DiscordIcon, XIcon, YouTubeIcon } from "vue3-simple-icons";

	import ApplicationLogo from "@/Components/ApplicationLogo.vue";
	import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>
<template>
	<footer class="bg-gray-800 text-gray-300">
		<div class="bg-gradient-to-b from-primary/15 via-black to-black">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
				<div class="grid grid-cols-1 md:grid-cols-6 gap-8">
					<!-- Brand Column -->
					<div class="space-y-4 md:col-span-2">
						<Link class="flex items-center" href="/">
							<ApplicationLogo
								class="block h-8 w-auto font-semibold" />
						</Link>

						<p class="text-sm font-semibold">
							Great memes for great fun.
						</p>
					</div>
					<!-- Explore Column -->
					<div>
						<ul class="space-y-4">
							<li>
								<Link
									href="/my-tokens"
									class="text-sm font-semibold hover:text-primary transition-colors">
									Explore
								</Link>
							</li>
							<li>
								<Link
									href="/my-tokens"
									class="text-sm font-semibold hover:text-primary transition-colors">
									My Tokens
								</Link>
							</li>
							<li>
								<Link
									href="/rewards"
									class="text-sm font-semibold hover:text-primary transition-colors">
									Rewards
								</Link>
							</li>
							<li>
								<Link
									href="/contributed"
									class="text-sm font-semibold hover:text-primary transition-colors">
									Contributions
								</Link>
							</li>
						</ul>
					</div>
					<!-- Resources Column -->
					<div>
						<ul class="space-y-4">
							<li>
								<Link
									href="/documentation"
									class="text-sm font-semibold hover:text-primary transition-colors">
									Policy
								</Link>
							</li>
							<li>
								<Link
									href="/documentation"
									class="text-sm font-semibold hover:text-primary transition-colors">
									Terms
								</Link>
							</li>
							<li>
								<Link
									href="/how-it-works"
									class="text-sm font-semibold hover:text-primary transition-colors">
									How it works
								</Link>
							</li>
							<li v-if="$page.props.links.documentation">
								<a
									:href="$page.props.links.documentation"
									class="inline-flex items-center space-x-2 text-sm font-semibold hover:text-primary transition-colors">
									<BookOpenCheckIcon class="w-5 h-5" />
									<span>Docs</span>
								</a>
							</li>
						</ul>
					</div>
					<!-- Social & Subscribe Column -->
					<div>
						<ul class="space-y-4">
							<li v-if="$page.props.links.twitter">
								<a
									:href="$page.props.links.twitter"
									class="inline-flex items-center space-x-2 text-sm font-semibold hover:text-primary transition-colors">
									<XIcon class="w-4 h-4" />
									<span>Twitter</span>
								</a>
							</li>
							<li v-if="$page.props.links.tgGroup">
								<a
									:href="$page.props.links.tgGroup"
									class="inline-flex items-center space-x-2 text-sm font-semibold hover:text-primary transition-colors">
									<LucideSend class="w-5 h-5" />

									<span>Telegram</span>
								</a>
							</li>

							<li v-if="$page.props.links.discord">
								<a
									:href="$page.props.links.discord"
									class="inline-flex items-center space-x-2 text-sm font-semibold hover:text-primary transition-colors">
									<DiscordIcon class="w-5 h-5" />
									<span>Discord</span>
								</a>
							</li>
							<li v-if="$page.props.links.youtube">
								<a
									:href="$page.props.links.youtube"
									class="inline-flex items-center space-x-2 text-sm font-semibold hover:text-primary transition-colors">
									<YouTubeIcon class="w-5 h-5" />
									<span>Discord</span>
								</a>
							</li>
						</ul>
					</div>
					<div class="space-y-4">
						<h3 class="text-white font-medium">
							Subscribe to notifications:
						</h3>
						<!-- Social Links -->

						<!-- Telegram Bot Button -->
						<PrimaryButton class="w-full justify-center">
							<svg
								class="w-5 h-5 mr-2"
								viewBox="0 0 24 24"
								fill="currentColor">
								<path
									d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.02-1.93 1.23-5.46 3.62-.52.36-.99.53-1.41.52-.46-.01-1.35-.26-2.01-.47-.81-.26-1.45-.4-1.4-.85.03-.22.46-.45 1.3-.68 5.09-2.22 8.49-3.68 10.19-4.4.73-.3 1.81-.76 2.21-.77.13 0 .41.03.6.19.17.14.22.34.25.49.02.12.03.77-.03 1.21z" />
							</svg>
							Telegram bot
						</PrimaryButton>
					</div>
				</div>
			</div>
		</div>
	</footer>
</template>
