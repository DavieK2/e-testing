<script>
    import { onMount } from "svelte";
    import Layout from "../../../../layouts/Layout.svelte";
    import { router } from "../../../../../util";


    onMount(() => {

        router.getWithToken(``)
    });
</script>

<Layout>

</Layout>