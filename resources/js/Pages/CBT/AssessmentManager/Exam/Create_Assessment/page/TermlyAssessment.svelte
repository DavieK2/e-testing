<script>
    import Icons from "../../../../../components/icons.svelte";
    import Layout from "../../../../../layouts/Layout.svelte";
    import Assessment from "../components/Assessment.svelte";
    import TermlyStepOne from "../components/TermlyStepOne.svelte";
    import TopHeader from "../../../../../layouts/top_header.svelte";
    import AppContainer from "../../../../../layouts/app_container.svelte";


    let step = {
        step : 1,
        placeholder : "Assessment Details",
    }


</script>

<Layout>
    <TopHeader title="Create Exam"/>

    <AppContainer>

            <Assessment { step }>
                <TermlyStepOne />
            </Assessment>
       
    </AppContainer>
    
  
</Layout>