<script>
    import { router } from "../../../util";
    import { page } from "@inertiajs/svelte";
    import Button from "../../components/button.svelte";
    import Input from "../../components/input.svelte";
    import { onMount } from "svelte";

    let studentCode;
    let assessmentId = $page.props.assessmentId
    let isLoading = false;

    $: disabled = isLoading;

    onMount(() => {
        localStorage.removeItem('token');
    });

    const login = async () => {

        isLoading = true;

        await router.post("/cbt/" + assessmentId, { studentCode : studentCode.value }, {

            onSuccess : (res) => {
                localStorage.setItem("token", res.data.token);
                return window.location.replace(res.data.url);
            },
            onError : (error) => {
                isLoading = false
                console.log(error);
            }
        });
    }
</script>


<svelte:document on:contextmenu|preventDefault />

<div class="bg-white dark:bg-gray-900">
    <div class="flex justify-center h-screen">
        <div class="hidden bg-cover lg:block lg:w-2/3" style="background-image: url('/images/bg-image-cbt.avif')">
            <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40">
                <div class="flex items-center space-x-4">
                    <div class="px-8 py-4 bg-white rounded-full">
                        <img src="/images/logo.png" height="150" width="150" class="rounded-full" alt="" srcset="">
                    </div>
                    <h2 class="text-6xl font-black text-white px-8 py-2 border-white border-2 rounded-full">CBT PORTAL</h2>
                </div>
            </div>
        </div>

        <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
            <div class="flex-1">
                <div class="text-left">
                    <p class="mt-3 text-gray-800 dark:text-gray-300 text-2xl font-bold">Enter your details below</p>
                </div>

                <div class="mt-8">
                    <div>
                        <Input bind:this={ studentCode } label="Enter Matric No. or Registration No." labelStyle="font-medium text-gray-700" />
                    </div>

                    <div class="mt-6">
                        <Button { disabled } on:click={ login } buttonText="Login" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>