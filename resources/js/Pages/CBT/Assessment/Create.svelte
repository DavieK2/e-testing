<script>
    import { onMount } from "svelte";
    import Icons from "../../components/icons.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import Assessment from "../components/Assessment.svelte";
    import StandaloneAssessment from "./StandaloneAssessment.svelte";

   

    onMount(() => {
      
    });

</script>

<!-- <Layout>
    <div class="mt-20 flex items-center justify-between border-b bg-white">
        <div class="flex space-x-3 items-center py-4 px-8">
            <Icons icon="chart" classList="h-5 w-5" />
            <span class="mx-2 text-sm font-medium text-gray-700">Assessments </span>
            <Icons icon="chevron_right" fill="#242121EB" classList="h-4 w-4" />
            <span class="text-sm font-medium text-gray-700">Create</span>
        </div>
    </div>
   <div class="w-full mx-auto h-full">
       
    { #if assessmentCategory === "standalone"}
        
        <StandaloneAssessment />
    
    {/if}

    { #if assessmentCategory === "termly"}
        
        <Assessment />

    {/if}

   </div>
    
</Layout> -->