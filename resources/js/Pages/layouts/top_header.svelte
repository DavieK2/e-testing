<script>
    import { cn } from "../components/utils";


    export let title;
    export let className = ''

</script>
<div class="fixed flex items-center h-16 justify-between bg-white py-4 px-6 border-b w-[calc(100vw-15rem)] z-50">
    <div class="flex space-x-3 items-center">
        <span class={ cn('text-[22px] font-bold text-gray-800', className) }>{ title }</span>
    </div>
    <slot></slot>
</div>