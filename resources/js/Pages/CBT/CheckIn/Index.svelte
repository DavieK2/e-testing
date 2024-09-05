<script>
    import { router } from "../../../util";
    import { page } from "@inertiajs/svelte";
    import Button from "../../components/button.svelte";
    import Input from "../../components/input.svelte";
    import { onMount } from "svelte";

    let assessmentId = $page.props.assessmentId;

    let studentCode;
    let subjects = []

    let studentData = {

        studentCode : "",
        studentName : "",
        studentLevel : "",
        studentPhoto : "",
    }

    let disabled = false
    let error = false;
    let errMsg = '';

    let selectedSubjects = [];

    $: disabled = ! ( studentData.studentCode && studentData.studentLevel && studentData.studentName )

    // onMount(() => {
        
    //     router.getWithToken('/api/assessment-subjects/' + assessmentId, {
    //         onSuccess : (res) => {
    //             subjects = res.data
    //         }
    //     })
    // });

    const getStudentData = () => {

        disabled = true;

        router.postWithToken('/api/student/check-in/get', { studentId : studentCode.value, assessmentId }, {

            onSuccess : (res) => {

                studentData.studentCode = res.data.studentCode
                studentData.studentName = res.data.studentName
                studentData.studentLevel = res.data.studentClass
                studentData.studentPhoto = res.data.studentPhoto
                subjects = res.data.subjects


                disabled = false;

                error = false
            },
            onError : (res) => {

                if( res.errors ){

                    error = true

                    errMsg = res.message
                }
            }
        })
    }

    const checkinStudent = () => {

        disabled = true;

        router.postWithToken('/api/student/check-in/' + assessmentId, { studentId : studentCode.value, subjects: selectedSubjects }, {

            onSuccess : (res) => {

                if( res.data.error ){

                    errMsg = res.data.error

                    error = true

                    return;
                }
                
                error = false;

                console.log( error )

                studentData = {}
                studentCode.value = '';
                selectedSubjects = []

                disabled = false
            }
        })
    }

</script>


<div class="max-h-screen min-h-screen  w-screen container">
   <div class="flex container rounded-lg p-12">
    <div class="container flex flex-1 flex-col justify-center px-20">
        <div class="flex flex-col py-12">
            <h1 class="font-extrabold text-4xl">Student Check In</h1>
            <div class="space-y-6 mt-12">
                <Input bind:this={ studentCode } label="Enter Student Reg Number"/>
            </div>

           <div class="mt-10">
                <Button buttonText="Get Student Data" on:click={ getStudentData } />
           </div>
        </div>
    </div>
    <div class="container flex flex-col max-w-[40rem] border-2 rounded-lg">
        { #if error }
            <div class="px-14 pt-16">
                <div class="p-5 rounded-lg min-w-max max-w-min bg-red-100 border-2 border-red-200 text-red-800">
                    <p>{ errMsg }</p>
                </div>
            </div>
        { /if } 
        <div class="flex flex-col py-12 w-full px-14">
            <h1 class="font-extrabold text-3xl">Student Info</h1>
            <div class="space-y-6 mt-12">
              <div class="rounded-lg bg-contain ">
                <img src={ `/${studentData.studentPhoto}` } alt="" class="rounded-lg flex h-44 min-w-max max-w-[11rem] w-auto bg-gray-300" >
              </div>
            </div>
            <div class="space-y-6 mt-12">
                <p class="font-semibold">Student Name: &nbsp;&nbsp;&nbsp;<span class="font-medium text-gray-700">{ studentData.studentName ?? "" }</span></p>
                <p class="font-semibold">Student Code: &nbsp;&nbsp;&nbsp;<span class="font-medium text-gray-700">{ studentData.studentCode  ?? ""}</span></p>
                <p class="font-semibold">Student Level: &nbsp;&nbsp;&nbsp;<span class="font-medium text-gray-700">{ studentData.studentLevel ?? "" }</span></p>
            </div>

            { #if studentData.studentCode }
                <div class="mt-6">
                    <p class="font-extrabold my-6 text-2xl">Courses</p>
                    <ul class="space-y-4 text-gray-600 text-sm">
                        { #each subjects as subject }
                            <li class="flex space-x-2">
                                <input bind:group={ selectedSubjects } type="checkbox" value={ subject.subjectId }>
                                <span>{ subject.subjectName } ({ subject.subjectCode })</span>
                            </li>
                        { /each }
                    </ul>
                </div>
            {/if}

           <div class="mt-10">
                <Button { disabled } className="max-w-fit" buttonText="Check In Student" on:click={ checkinStudent } />
           </div>
        </div>
        
    </div>
   </div>
</div>