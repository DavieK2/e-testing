<script>
    import { fade } from "svelte/transition";
    import Icons from "./icons.svelte";
    import { cn } from "./utils";
    import { quintIn, backOut } from "svelte/easing";

    export let placeholder
    export let className = '';
    export let arrowColor = "fill-white";

    let showDropdown = false
    let shouldFlip = false
    let isMouseOnDropDown = false;

    const show = () => showDropdown = ! showDropdown;

    const hide = (node) => {

        node.addEventListener('focusout', () => {

            if( isMouseOnDropDown ){

                node.focus();

                return ;
            }

          
            setTimeout(() => { 
                showDropdown = false
                shouldFlip = false
            }, 100)
            
        })

    }

     const flip = (node) => {

            const observer = new IntersectionObserver((entries) => {

                if( ! entries[0].isIntersecting ) return;

                if( entries[0].boundingClientRect.bottom > document.documentElement.clientHeight ){

                    shouldFlip = true

                }
                
            })

            observer.observe(node);

      
    }
</script>

<div class="relative overflow-visible">

    <div class="min-w-max">
        <button on:click={ show } use:hide name="" class={ cn(`block min-w-max max-w-min rounded-lg border-0 py-1.5 px-3 bg-gray-800 text-white  placeholder:text-gray-400 focus:ring-inset focus:ring-gray-800 text-xs sm:leading-6`, className ) }>
            <div class="flex items-center justify-between space-x-3">
                <span >{ placeholder }</span>
                <div class="flex items-center justify-center space-x-2">
                    <div class="h-5 w-px bg-gray-300"></div>
                    { #if showDropdown }
                        <Icons icon="chevron_up" className={ arrowColor } />
                    { :else }
                        <Icons icon="chevron_down" className={ arrowColor } />
                    { /if }
                </div>
               
            </div>
        </button>  
    </div>
    
    { #if showDropdown }
        <!-- svelte-ignore a11y-mouse-events-have-key-events -->
        <!-- svelte-ignore a11y-no-static-element-interactions -->
        <div use:flip on:mouseover={ () => isMouseOnDropDown = true } on:mouseleave={ () => isMouseOnDropDown = false } out:fade={{ duration: 100, easing: backOut }} in:fade={{ duration: 50, easing: quintIn }} class={`${ shouldFlip ? 'bottom-14' : '' } absolute isolate left-0  origin-bottom-right flex flex-col items-start p-3 min-w-max max-w-min min-h-max max-h-min mt-2  bg-white border rounded-lg z-50 text-gray-700`}>
            <div class="flex flex-col h-full overflow-y-auto">
                <slot></slot>
            </div>
        </div>
    { /if }
</div>