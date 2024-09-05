<script lang="ts">
	import { Dialog as SheetPrimitive } from "bits-ui";
	import { cn } from "../../utils";
	import X from "lucide-svelte/icons/x";

	type $$Props = SheetPrimitive.TitleProps;

	let className: $$Props["class"] = undefined;
	export { className as class };
</script>

<SheetPrimitive.Title
	class={cn("text-lg font-semibold text-foreground", className)}
	{...$$restProps}
>
	<div class="flex items-center justify-between px-6 pb-4 border-b -mx-6 h-12">
		<slot />
		<SheetPrimitive.Close
			class="rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-secondary"
		>
			<X class="h-5 w-5" />
			<span class="sr-only">Close</span>
		</SheetPrimitive.Close>
	</div>
	
</SheetPrimitive.Title>
