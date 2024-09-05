<script>
    import { createEventDispatcher } from "svelte";
    import * as Drawer from "../../components/ui/drawer";
    import { cn } from "./utils";

    export let title = '';
    export let show = false;
    export let className = '';

    const dispatch = createEventDispatcher();

</script>

<Drawer.Root open={ show } closeOnOutsideClick={ false } onOpenChange={ (e) => dispatch('status') }>
    <Drawer.Content class={ cn(`w-full`, className )}>
        <Drawer.Header>
            <Drawer.Title class="flex w-full justify-center text-center items-center font-black text-3xl text-gray-800 p-4">{ title }</Drawer.Title>
            <Drawer.Description>
                <div class="p-6">
                    <slot name="drawer"></slot>
                </div>
            </Drawer.Description>
        </Drawer.Header>
    </Drawer.Content>
</Drawer.Root>