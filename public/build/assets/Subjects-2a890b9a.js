import{S as Q,i as z,s as D,c as x,m as w,t as k,a as y,d as v,b as H,o as W,f as m,g as b,h as _,j,k as u,l as S,p as E,w as N,x as F,y as G,z as J,A as K,B as O,n as q,q as A}from"./app-6d9f305e.js";import P from"./data_table-2f3c9d25.js";import R from"./layout-f16eab42.js";import{r as M}from"./util-f704b04e.js";import U from"./button-8a7fdb21.js";import"./input-694295df.js";import"./utils-4fba9a6a.js";import"./tw-merge-0f2443f8.js";import"./link-7d7fab16.js";import"./icons-c5a046aa.js";function B(i,t,s){const a=i.slice();return a[6]=t[s],a[8]=s,a}function I(i,t){let s,a,n=t[8]+1+"",o,c,e,r=t[6].subjectName+"",l,T,$,g,f,C,d;function L(){return t[3](t[6])}return f=new U({props:{buttonText:"Set Questions"}}),f.$on("click",L),{key:i,first:null,c(){s=m("tr"),a=m("td"),o=q(n),c=b(),e=m("td"),l=q(r),T=b(),$=m("td"),g=m("div"),x(f.$$.fragment),C=b(),_(a,"class","px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap"),_(e,"class","px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap"),_(g,"class","w-40"),_($,"class","px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap"),this.first=s},m(p,h){j(p,s,h),u(s,a),u(a,o),u(s,c),u(s,e),u(e,l),u(s,T),u(s,$),u($,g),w(f,g,null),u(s,C),d=!0},p(p,h){t=p,(!d||h&1)&&n!==(n=t[8]+1+"")&&A(o,n),(!d||h&1)&&r!==(r=t[6].subjectName+"")&&A(l,r)},i(p){d||(k(f.$$.fragment,p),d=!0)},o(p){y(f.$$.fragment,p),d=!1},d(p){p&&S(s),v(f)}}}function V(i){let t=[],s=new Map,a,n,o=N(i[0]);const c=e=>e[6].subjectId;for(let e=0;e<o.length;e+=1){let r=B(i,o,e),l=c(r);s.set(l,t[e]=I(l,r))}return{c(){for(let e=0;e<t.length;e+=1)t[e].c();a=F()},m(e,r){for(let l=0;l<t.length;l+=1)t[l]&&t[l].m(e,r);j(e,a,r),n=!0},p(e,r){r&5&&(o=N(e[0]),G(),t=J(t,r,c,1,e,o,s,a.parentNode,K,I,a,B),O())},i(e){if(!n){for(let r=0;r<o.length;r+=1)k(t[r]);n=!0}},o(e){for(let r=0;r<t.length;r+=1)y(t[r]);n=!1},d(e){e&&S(a);for(let r=0;r<t.length;r+=1)t[r].d(e)}}}function X(i){let t,s,a,n,o;return n=new P({props:{headings:i[1],$$slots:{default:[V]},$$scope:{ctx:i}}}),{c(){t=m("div"),s=m("div"),s.innerHTML='<h3 class="text-lg font-semibold">Classes</h3>',a=b(),x(n.$$.fragment),_(s,"class","container px-4"),_(t,"class","px-6 my-28")},m(c,e){j(c,t,e),u(t,s),u(t,a),w(n,t,null),o=!0},p(c,e){const r={};e&513&&(r.$$scope={dirty:e,ctx:c}),n.$set(r)},i(c){o||(k(n.$$.fragment,c),o=!0)},o(c){y(n.$$.fragment,c),o=!1},d(c){c&&S(t),v(n)}}}function Y(i){let t,s;return t=new R({props:{$$slots:{default:[X]},$$scope:{ctx:i}}}),{c(){x(t.$$.fragment)},m(a,n){w(t,a,n),s=!0},p(a,[n]){const o={};n&513&&(o.$$scope={dirty:n,ctx:a}),t.$set(o)},i(a){s||(k(t.$$.fragment,a),s=!0)},o(a){y(t.$$.fragment,a),s=!1},d(a){v(t,a)}}}function Z(i,t,s){let a;H(i,E,l=>s(4,a=l));let n=["S/N","Subject","Actions"],o=[],c=a.props.classCode;W(()=>{M.getWithToken("/api/get-subjects/",{onSuccess:l=>{s(0,o=l.data)}})});const e=l=>{M.navigateTo(`/teacher/create-questions/${c}/${l}`)};return[o,n,e,l=>e(l.subjectId)]}class ut extends Q{constructor(t){super(),z(this,t,Z,Y,D,{})}}export{ut as default};
