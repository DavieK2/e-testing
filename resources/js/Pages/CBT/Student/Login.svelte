<script>
    import { router } from "../../../util";
    import Button from "../../components/button.svelte";
    import Input from "../../components/input.svelte";

    let email = "";
    let password = "";

    const login = async () => {

        await router.post("/login", { email, password }, {

            onSuccess : (response) => {
                
                localStorage.setItem("token", response.token);
                return router.navigateTo("/2fa");
            },
            onError : (error) => {
                console.log(error);
            }
        });
    }
</script>

<div class="bg-white dark:bg-gray-900">
    <div class="flex justify-center h-screen">
        <div class="hidden bg-cover lg:block lg:w-2/3" style="background-image: url(https://images.unsplash.com/photo-1616763355603-9755a640a287?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80)">
            <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40">
                <div>
                    <h2 class="text-2xl font-bold text-white sm:text-3xl">JEPHTHAH CBT</h2>

                    <p class="max-w-xl mt-3 text-gray-300">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. In
                        autem ipsa, nulla laboriosam dolores, repellendus perferendis libero suscipit nam temporibus
                        molestiae
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
            <div class="flex-1">
                <div class="text-left">
                    <p class="mt-3 text-gray-800 dark:text-gray-300 text-2xl font-semibold">Enter your details below</p>
                </div>

                <div class="mt-8">
                    <form>
                        <div>
                            <Input label="Enter Student Code" />
                        </div>

                        <div class="mt-6">
                            <Input label="Enter Password" type="password" />
                        </div>

                        <div class="mt-6">
                           <Button buttonText="Submit" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>