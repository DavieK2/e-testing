<script>
    import { createEventDispatcher } from 'svelte';
    import * as Sheet from '../../components/ui/sheet'

    const dispatch = createEventDispatcher();
    export let showSheet = false
    export let title;

</script>


<Sheet.Root open={ showSheet } closeOnOutsideClick={ false } onOpenChange={ (status) => dispatch('onpanelstatus', { status })}>
    <slot></slot>
    <Sheet.Content class="bg-white shadow-sm">
        <Sheet.Header>
            <Sheet.Title class="font-bold">{ title }</Sheet.Title>
            <Sheet.Description class="min-w-[28rem] bg-white h-[calc(100vh-5rem)] overflow-y-auto -mx-6">
                <div class="p-6">
                    <slot name="panel"></slot>
                </div>
            </Sheet.Description>
        </Sheet.Header>
    </Sheet.Content>
</Sheet.Root>