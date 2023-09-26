<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
   
    {{-- <link rel="stylesheet" href="{{  asset('build/assets/app-fa0957b9.css') }}"> --}}
   
    <style>
        .flex {
            display: flex
        }
        .flex-col{
            flex-direction: column
        }
        .justify-center{
            justify-content: center
        }
        .items-center{
            align-items: center
        }
        .uppercase{
            text-transform: uppercase
        }
        .text-center{
            text-align: center
        }
        .rounded-lg{
            border-radius: 0.5rem
        }
        .text-3xl {
            font-size: 24px;
            line-height: 32px;
            font-weight: 800
        }
    </style>
  </head>
  <body style="font-size: 14px">
    <div class="flex w-full justify-center" style="width: 100vw">
            <div id="result" class="mt-12 w-[65rem] h-full p-8 rounded-lg bg-white border border-gray-200 text-gray-800 relative">
               <div class="flex flex-col w-full space-y-4 items-center pt-4">
                    <center>
                        <img src={{ base_path("public/images/logo.png") }} alt="" class="rounded-lg" style="text-align: center" height="160" width="160" />
                    </center>
                    <div class="pb-12 text-3xl font-extrabold uppercase text-center" style="padding-bottom: 3rem">{{ $assessmentTitle }} Report</div>
               </div>
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <img src={{ $studentPhoto }} alt="" class="rounded-lg" height="150" width="190" />
                    </div>
                    <div class="mt-8 space-y-3 uppercase" style="margin-top: 1.5rem">
                        <p class="font-bold text-gray-800" style="font-weight: 700">Student Name : <span class="font-normal text-gray-700" style="font-weight: 400"> {{ $studentName }}</span></p>
                        <p class="font-bold text-gray-800" style="font-weight: 700">Reg No : <span class="font-normal text-gray-700" style="font-weight: 400">{{ $studentId }}</span></p>
                        <p class="font-bold text-gray-800" style="font-weight: 700">Level : <span class="font-normal text-gray-700" style="font-weight: 400">{{ $studentClass }}</span></p>
                    </div>
                </div>

                <table class="w-full mt-12 z-50" style="margin-top: 3rem">
                    <thead class="uppercase bg-gray-100" style="">
                        <th class="p-4 text-left" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">S/N</th>
                        <th class="p-4 text-left" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">Course Name</th>
                        <th class="p-4 text-left" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">Course Code</th>
                        <th class="p-4 text-left" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">Score</th>
                        <th class="p-4 text-left" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">Grade</th>
                        <th class="p-4 text-left" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">Remarks</th>
                    </thead>
                    <tbody>
                        @foreach ($studentResults ?? [] as $index => $result)
                            <tr>
                                <td class="p-4" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">{{ $index + 1 }}</td>
                                <td class="p-4" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">{{ $result->subjectName }}</td>
                                <td class="p-4" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">{{ $result->subjectCode }}</td>
                                <td class="p-4" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">{{ $result->score }}</td>
                                <td class="p-4" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">{{ $result->grade }}</td>
                                <td class="p-4" style=" padding-right: 1.5rem; padding-bottom: 1.5rem; text-align: left">{{ $result->remarks }}</td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
  </body>
</html>