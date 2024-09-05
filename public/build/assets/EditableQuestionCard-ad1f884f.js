import{S as je,i as Ee,s as x,f as w,g as E,c as G,h as p,j as F,k as b,m as H,C as Z,a as y,B as M,t as _,l as R,d as K,b as Be,F as Oe,o as Ae,y as z,u as $,w as ne,D as De,p as Je,n as _e}from"./app-6d9f305e.js";import{r as se}from"./util-f704b04e.js";import te from"./icons-c5a046aa.js";import Fe from"./input-694295df.js";import ge from"./TextEditor-45bc4bcb.js";import be from"./select-5f1b2e78.js";import{c as le}from"./utils-4fba9a6a.js";import"./tw-merge-0f2443f8.js";import"./button-8a7fdb21.js";import"./index-000d58f7.js";function oe(n,t,e){const s=n.slice();return s[50]=t[e],s[52]=e,s}function re(n){let t,e;return t=new be({props:{options:n[8],value:n[2],placeholder:"Select Question Section",className:"text-sm ring-2"}}),t.$on("selected",n[33]),t.$on("deselected",n[34]),{c(){G(t.$$.fragment)},m(s,r){H(t,s,r),e=!0},p(s,r){const i={};r[0]&256&&(i.options=s[8]),r[0]&4&&(i.value=s[2]),t.$set(i)},i(s){e||(_(t.$$.fragment,s),e=!0)},o(s){y(t.$$.fragment,s),e=!1},d(s){K(t,s)}}}function ie(n){let t,e,s,r=n[4],i,o=ue(n);return{c(){t=w("div"),e=w("p"),e.textContent="Select Question Topic",s=E(),o.c(),p(e,"class","text-gray-800 font-semibold text-sm"),p(t,"class","space-y-4 pb-4 my-4")},m(d,u){F(d,t,u),b(t,e),b(t,s),o.m(t,null),i=!0},p(d,u){u[0]&16&&x(r,r=d[4])?(z(),y(o,1,1,$),M(),o=ue(d),o.c(),_(o,1),o.m(t,null)):o.p(d,u)},i(d){i||(_(o),i=!0)},o(d){y(o),i=!1},d(d){d&&R(t),o.d(d)}}}function ue(n){let t,e;return t=new be({props:{options:n[9],value:n[4],placeholder:"Select Question Topic",className:"text-sm ring-2"}}),t.$on("selected",n[35]),t.$on("deselected",n[36]),{c(){G(t.$$.fragment)},m(s,r){H(t,s,r),e=!0},p(s,r){const i={};r[0]&512&&(i.options=s[9]),r[0]&16&&(i.value=s[4]),t.$set(i)},i(s){e||(_(t.$$.fragment,s),e=!0)},o(s){y(t.$$.fragment,s),e=!1},d(s){K(t,s)}}}function ce(n){let t,e;return t=new ge({props:{id:"questionEditor",content:n[3],showTools:!0}}),t.$on("input",n[37]),{c(){G(t.$$.fragment)},m(s,r){H(t,s,r),e=!0},p(s,r){const i={};r[0]&8&&(i.content=s[3]),t.$set(i)},i(s){e||(_(t.$$.fragment,s),e=!0)},o(s){y(t.$$.fragment,s),e=!1},d(s){K(t,s)}}}function fe(n){let t,e,s,r,i=ne(n[0]),o=[];for(let u=0;u<i.length;u+=1)o[u]=me(oe(n,i,u));const d=u=>y(o[u],1,1,()=>{o[u]=null});return{c(){t=w("p"),t.textContent="Options",e=E(),s=w("ul");for(let u=0;u<o.length;u+=1)o[u].c();p(t,"class","text-gray-800 font-bold text-lg pt-4 pb-2"),p(s,"class","flex flex-col w-full space-y-2 text-xs text-gray-600 pt-2")},m(u,c){F(u,t,c),F(u,e,c),F(u,s,c);for(let f=0;f<o.length;f+=1)o[f]&&o[f].m(s,null);r=!0},p(u,c){if(c[0]&757889){i=ne(u[0]);let f;for(f=0;f<i.length;f+=1){const B=oe(u,i,f);o[f]?(o[f].p(B,c),_(o[f],1)):(o[f]=me(B),o[f].c(),_(o[f],1),o[f].m(s,null))}for(z(),f=i.length;f<o.length;f+=1)d(f);M()}},i(u){if(!r){for(let c=0;c<i.length;c+=1)_(o[c]);r=!0}},o(u){o=o.filter(Boolean);for(let c=0;c<o.length;c+=1)y(o[c]);r=!1},d(u){u&&(R(t),R(e),R(s)),De(o,u)}}}function ae(n){let t,e;function s(...r){return n[39](n[52],...r)}return t=new ge({props:{id:n[52],content:n[50].htmlContent,isOptionEditor:!0}}),t.$on("input",s),{c(){G(t.$$.fragment)},m(r,i){H(t,r,i),e=!0},p(r,i){n=r;const o={};i[0]&1&&(o.content=n[50].htmlContent),t.$set(o)},i(r){e||(_(t.$$.fragment,r),e=!0)},o(r){y(t.$$.fragment,r),e=!1},d(r){K(t,r)}}}function de(n){let t,e,s,r,i;return e=new te({props:{icon:"plus",className:"stroke-gray-400"}}),{c(){t=w("button"),G(e.$$.fragment),p(t,"class","flex items-center shrink-0 justify-center h-11 w-11 border-2 border-gray-300 rounded-lg")},m(o,d){F(o,t,d),H(e,t,null),s=!0,r||(i=Z(t,"click",n[16]),r=!0)},p:$,i(o){s||(_(e.$$.fragment,o),s=!0)},o(o){y(e.$$.fragment,o),s=!1},d(o){o&&R(t),K(e),r=!1,i()}}}function Re(n){let t,e,s,r,i;e=new te({props:{icon:"trash",className:"stroke-gray-400"}});function o(){return n[40](n[52])}return{c(){t=w("button"),G(e.$$.fragment),p(t,"class","flex items-center shrink-0 justify-center h-11 w-11 border-2 border-gray-300 rounded-lg")},m(d,u){F(d,t,u),H(e,t,null),s=!0,r||(i=Z(t,"click",o),r=!0)},p(d,u){n=d},i(d){s||(_(e.$$.fragment,d),s=!0)},o(d){y(e.$$.fragment,d),s=!1},d(d){d&&R(t),K(e),r=!1,i()}}}function me(n){var h;let t,e,s,r,i,o,d=n[7],u,c,f,B,U,j;s=new te({props:{icon:"check",className:n[12](((h=n[50])==null?void 0:h.content)??n[50])?"stroke-green-500":"stroke-gray-400"}});function V(){return n[38](n[50])}let q=ae(n),m=n[52]+1==n[0].length&&de(n),S=n[52]>1&&Re(n);return{c(){var T;t=w("div"),e=w("button"),G(s.$$.fragment),i=E(),o=w("div"),q.c(),u=E(),m&&m.c(),c=E(),S&&S.c(),f=E(),p(e,"class",r=`flex items-center shrink-0 justify-center h-11 w-11 border-2 ${n[12](((T=n[50])==null?void 0:T.content)??n[50])?"border-green-500":"border-gray-300"} rounded-lg`),p(o,"class","w-full"),p(t,"class","flex space-x-2 items-center w-full")},m(T,I){F(T,t,I),b(t,e),H(s,e,null),b(t,i),b(t,o),q.m(o,null),b(t,u),m&&m.m(t,null),b(t,c),S&&S.m(t,null),b(t,f),B=!0,U||(j=Z(e,"click",V),U=!0)},p(T,I){var W,J;n=T;const D={};I[0]&4097&&(D.className=n[12](((W=n[50])==null?void 0:W.content)??n[50])?"stroke-green-500":"stroke-gray-400"),s.$set(D),(!B||I[0]&4097&&r!==(r=`flex items-center shrink-0 justify-center h-11 w-11 border-2 ${n[12](((J=n[50])==null?void 0:J.content)??n[50])?"border-green-500":"border-gray-300"} rounded-lg`))&&p(e,"class",r),I[0]&128&&x(d,d=n[7])?(z(),y(q,1,1,$),M(),q=ae(n),q.c(),_(q,1),q.m(o,null)):q.p(n,I),n[52]+1==n[0].length?m?(m.p(n,I),I[0]&1&&_(m,1)):(m=de(n),m.c(),_(m,1),m.m(t,c)):m&&(z(),y(m,1,1,()=>{m=null}),M()),n[52]>1&&S.p(n,I)},i(T){B||(_(s.$$.fragment,T),_(q),_(m),_(S),B=!0)},o(T){y(s.$$.fragment,T),y(q),y(m),y(S),B=!1},d(T){T&&R(t),K(s),q.d(T),m&&m.d(),S&&S.d(),U=!1,j()}}}function Ue(n){let t,e,s,r;return{c(){t=w("button"),e=_e("Save Question"),t.disabled=n[6],p(t,"class","px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-sm disabled:bg-gray-500")},m(i,o){F(i,t,o),b(t,e),s||(r=Z(t,"click",n[21]),s=!0)},p(i,o){o[0]&64&&(t.disabled=i[6])},d(i){i&&R(t),s=!1,r()}}}function Ve(n){let t,e,s,r;return{c(){t=w("button"),e=_e("Update Question"),t.disabled=n[6],p(t,"class","px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-sm disabled:bg-gray-500")},m(i,o){F(i,t,o),b(t,e),s||(r=Z(t,"click",n[20]),s=!0)},p(i,o){o[0]&64&&(t.disabled=i[6])},d(i){i&&R(t),s=!1,r()}}}function We(n){let t,e,s,r,i,o=n[2],d,u,c,f,B,U=n[3]&&n[7],j,V,q,m,S,h,T,I,D,W,J,L,P,X,N=re(n),g=!n[5]&&ie(n),O=ce(n),k=n[11]!=n[13].theory&&fe(n);h=new Fe({props:{value:n[1]??"1",type:"number",className:"ring-2"}}),h.$on("input",n[41]);function v(a,Q){return a[5]?Ve:Ue}let Y=v(n),A=Y(n);return{c(){t=w("div"),e=w("div"),s=w("div"),r=w("p"),r.textContent="Select Question Section",i=E(),N.c(),d=E(),g&&g.c(),u=E(),c=w("div"),f=w("p"),f.textContent="Question",B=E(),O.c(),j=E(),k&&k.c(),V=E(),q=w("div"),m=w("p"),m.textContent="Question Score",S=E(),G(h.$$.fragment),T=E(),I=w("div"),D=w("button"),D.textContent="Cancel",W=E(),A.c(),p(r,"class","text-gray-800 font-semibold text-sm"),p(s,"class","space-y-4 pb-4 my-4"),p(f,"class","text-blue-600 font-extrabold text-sm border uppercase border-blue-200 px-4 py-2 max-w-min min-w-max bg-blue-100 rounded-md"),p(c,"class","space-y-4 my-4"),p(m,"class","text-gray-800 font-semibold text-sm "),p(q,"class","w-32 mt-6 space-y-2"),p(D,"class","px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm"),p(I,"class","flex space-x-2 pt-5"),p(e,"class","pb-6"),p(t,"class",J=le("flex flex-col px-3 pb-4",n[10]))},m(a,Q){F(a,t,Q),b(t,e),b(e,s),b(s,r),b(s,i),N.m(s,null),b(e,d),g&&g.m(e,null),b(e,u),b(e,c),b(c,f),b(c,B),O.m(c,null),b(e,j),k&&k.m(e,null),b(e,V),b(e,q),b(q,m),b(q,S),H(h,q,null),b(e,T),b(e,I),b(I,D),b(I,W),A.m(I,null),L=!0,P||(X=Z(D,"click",n[42]),P=!0)},p(a,Q){Q[0]&4&&x(o,o=a[2])?(z(),y(N,1,1,$),M(),N=re(a),N.c(),_(N,1),N.m(s,null)):N.p(a,Q),a[5]?g&&(z(),y(g,1,1,()=>{g=null}),M()):g?(g.p(a,Q),Q[0]&32&&_(g,1)):(g=ie(a),g.c(),_(g,1),g.m(e,u)),Q[0]&136&&x(U,U=a[3]&&a[7])?(z(),y(O,1,1,$),M(),O=ce(a),O.c(),_(O,1),O.m(c,null)):O.p(a,Q),a[11]!=a[13].theory?k?(k.p(a,Q),Q[0]&2048&&_(k,1)):(k=fe(a),k.c(),_(k,1),k.m(e,V)):k&&(z(),y(k,1,1,()=>{k=null}),M());const ee={};Q[0]&2&&(ee.value=a[1]??"1"),h.$set(ee),Y===(Y=v(a))&&A?A.p(a,Q):(A.d(1),A=Y(a),A&&(A.c(),A.m(I,null))),(!L||Q[0]&1024&&J!==(J=le("flex flex-col px-3 pb-4",a[10])))&&p(t,"class",J)},i(a){L||(_(N),_(g),_(O),_(k),_(h.$$.fragment,a),L=!0)},o(a){y(N),y(g),y(O),y(k),y(h.$$.fragment,a),L=!1},d(a){a&&R(t),N.d(a),g&&g.d(),O.d(a),k&&k.d(),K(h),A.d(),P=!1,X()}}}function Le(n,t,e){let s,r;Be(n,Je,l=>e(44,r=l));let{edit:i=!1}=t,{disabled:o=!1}=t,{questionEdit:d=!1}=t,{correctAnswer:u=""}=t,{options:c=[]}=t,{sections:f=[]}=t,{topics:B=[]}=t,{className:U=""}=t,{questionScore:j="1"}=t,{questionType:V=""}=t,{assigned:q=!1}=t,{question:m=""}=t,{selectedTopic:S=""}=t,{selectedSection:h=""}=t,{questionId:T}=t,{questionBankId:I}=t,{questionBank:D=!1}=t,{questionImage:W=""}=t,{subjectId:J=null}=t,{classId:L=null}=t,{source:P}=t,X=[];r.props.role;let N={objectives:"objectives",picture:"picture",video:"video",math:"math",theory:"theory"},g=N.objectives,O=r.props.assessmentId;const k=Oe();Ae(()=>{JSON.stringify(c)});const v=l=>e(22,u=l),Y=()=>{c.push({content:"<p></p>",type:""}),e(0,c),e(2,h),e(8,f),e(11,g),e(13,N),e(1,j)},A=(l,C)=>{e(0,c[C]={content:l.content,type:l.type,alt:l.alt},c)},a=l=>e(3,m=l),Q=l=>{e(0,c=c.filter((C,Qe)=>Qe!=l))},ee=()=>{k("saving");let l={question:JSON.stringify(m),options:c,correctAnswer:u,questionScore:j,source:P,sectionId:h,topicId:S,questionBankId:I,questionType:g??V,subjectId:J,classId:L,assigned:q,questionBank:D};se.postWithToken("/api/question/update/"+T,l,{onSuccess:C=>{k("updated",{question:l})},onError:C=>{k("error")}})},ke=()=>{k("saving");let l={question:JSON.stringify(m),options:c,correctAnswer:u,questionScore:j};se.postWithToken("/api/question/create/"+O,{...l,sectionId:h,topicId:S,questionBankId:I,questionType:g},{onSuccess:C=>{l.questionId=C.data.questionId,k("saved",{question:{...l,sectionId:h,topicId:S}})},onError:C=>{k("error")}})},he=l=>e(2,h=l.detail.value),ye=l=>e(2,h=null),pe=l=>e(4,S=l.detail.value),qe=l=>e(4,S=null),Ie=l=>a(l.detail),we=l=>v((l==null?void 0:l.content)??l),Se=(l,C)=>A(C.detail,l),Te=l=>Q(l),Ce=l=>e(1,j=l.detail.input),Ne=()=>k("cancel");return n.$$set=l=>{"edit"in l&&e(5,i=l.edit),"disabled"in l&&e(6,o=l.disabled),"questionEdit"in l&&e(7,d=l.questionEdit),"correctAnswer"in l&&e(22,u=l.correctAnswer),"options"in l&&e(0,c=l.options),"sections"in l&&e(8,f=l.sections),"topics"in l&&e(9,B=l.topics),"className"in l&&e(10,U=l.className),"questionScore"in l&&e(1,j=l.questionScore),"questionType"in l&&e(24,V=l.questionType),"assigned"in l&&e(25,q=l.assigned),"question"in l&&e(3,m=l.question),"selectedTopic"in l&&e(4,S=l.selectedTopic),"selectedSection"in l&&e(2,h=l.selectedSection),"questionId"in l&&e(26,T=l.questionId),"questionBankId"in l&&e(27,I=l.questionBankId),"questionBank"in l&&e(28,D=l.questionBank),"questionImage"in l&&e(23,W=l.questionImage),"subjectId"in l&&e(29,J=l.subjectId),"classId"in l&&e(30,L=l.classId),"source"in l&&e(31,P=l.source)},n.$$.update=()=>{var l;if(n.$$.dirty[0]&4194304&&e(12,s=C=>(C==null?void 0:C.length)>0&&C===u),n.$$.dirty[1]&2&&X[0]){let C=new FileReader;C.readAsDataURL(X[0]),C.onload=()=>{e(23,W=C.result)}}n.$$.dirty[0]&2311&&(h&&e(11,g=(l=f.filter(C=>C.value===h)[0])==null?void 0:l.questionType),g===N.theory?(e(1,j="0"),e(0,c),e(2,h),e(8,f),e(11,g),e(13,N),e(1,j)):(e(1,j),e(2,h),e(8,f),e(11,g),e(13,N),e(0,c),e(0,c),e(2,h),e(8,f),e(11,g),e(13,N),e(1,j)))},[c,j,h,m,S,i,o,d,f,B,U,g,s,N,k,v,Y,A,a,Q,ee,ke,u,W,V,q,T,I,D,J,L,P,X,he,ye,pe,qe,Ie,we,Se,Te,Ce,Ne]}class xe extends je{constructor(t){super(),Ee(this,t,Le,We,x,{edit:5,disabled:6,questionEdit:7,correctAnswer:22,options:0,sections:8,topics:9,className:10,questionScore:1,questionType:24,assigned:25,question:3,selectedTopic:4,selectedSection:2,questionId:26,questionBankId:27,questionBank:28,questionImage:23,subjectId:29,classId:30,source:31},null,[-1,-1])}}export{xe as default};
