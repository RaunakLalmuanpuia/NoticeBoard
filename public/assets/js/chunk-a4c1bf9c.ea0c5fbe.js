(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-a4c1bf9c"],{"0fd9":function(t,e,n){"use strict";n("4b85");var s=n("2b0e"),r=n("d9f7"),a=n("80d2");const o=["sm","md","lg","xl"],i=["start","end","center"];function l(t,e){return o.reduce((n,s)=>(n[t+Object(a["G"])(s)]=e(),n),{})}const c=t=>[...i,"baseline","stretch"].includes(t),u=l("align",()=>({type:String,default:null,validator:c})),d=t=>[...i,"space-between","space-around"].includes(t),f=l("justify",()=>({type:String,default:null,validator:d})),p=t=>[...i,"space-between","space-around","stretch"].includes(t),g=l("alignContent",()=>({type:String,default:null,validator:p})),b={align:Object.keys(u),justify:Object.keys(f),alignContent:Object.keys(g)},h={align:"align",justify:"justify",alignContent:"align-content"};function m(t,e,n){let s=h[t];if(null!=n){if(e){const n=e.replace(t,"");s+="-"+n}return s+="-"+n,s.toLowerCase()}}const y=new Map;e["a"]=s["a"].extend({name:"v-row",functional:!0,props:{tag:{type:String,default:"div"},dense:Boolean,noGutters:Boolean,align:{type:String,default:null,validator:c},...u,justify:{type:String,default:null,validator:d},...f,alignContent:{type:String,default:null,validator:p},...g},render(t,{props:e,data:n,children:s}){let a="";for(const r in e)a+=String(e[r]);let o=y.get(a);if(!o){let t;for(t in o=[],b)b[t].forEach(n=>{const s=e[n],r=m(t,n,s);r&&o.push(r)});o.push({"no-gutters":e.noGutters,"row--dense":e.dense,["align-"+e.align]:e.align,["justify-"+e.justify]:e.justify,["align-content-"+e.alignContent]:e.alignContent}),y.set(a,o)}return t(e.tag,Object(r["a"])(n,{staticClass:"row",class:o}),s)}})},"3ff5":function(t,e,n){},"46f0":function(t,e,n){"use strict";n("3ff5")},"62ad":function(t,e,n){"use strict";n("4b85");var s=n("2b0e"),r=n("d9f7"),a=n("80d2");const o=["sm","md","lg","xl"],i=(()=>o.reduce((t,e)=>(t[e]={type:[Boolean,String,Number],default:!1},t),{}))(),l=(()=>o.reduce((t,e)=>(t["offset"+Object(a["G"])(e)]={type:[String,Number],default:null},t),{}))(),c=(()=>o.reduce((t,e)=>(t["order"+Object(a["G"])(e)]={type:[String,Number],default:null},t),{}))(),u={col:Object.keys(i),offset:Object.keys(l),order:Object.keys(c)};function d(t,e,n){let s=t;if(null!=n&&!1!==n){if(e){const n=e.replace(t,"");s+="-"+n}return"col"!==t||""!==n&&!0!==n?(s+="-"+n,s.toLowerCase()):s.toLowerCase()}}const f=new Map;e["a"]=s["a"].extend({name:"v-col",functional:!0,props:{cols:{type:[Boolean,String,Number],default:!1},...i,offset:{type:[String,Number],default:null},...l,order:{type:[String,Number],default:null},...c,alignSelf:{type:String,default:null,validator:t=>["auto","start","end","center","baseline","stretch"].includes(t)},tag:{type:String,default:"div"}},render(t,{props:e,data:n,children:s,parent:a}){let o="";for(const r in e)o+=String(e[r]);let i=f.get(o);if(!i){let t;for(t in i=[],u)u[t].forEach(n=>{const s=e[n],r=d(t,n,s);r&&i.push(r)});const n=i.some(t=>t.startsWith("col-"));i.push({col:!n||!e.cols,["col-"+e.cols]:e.cols,["offset-"+e.offset]:e.offset,["order-"+e.order]:e.order,["align-self-"+e.alignSelf]:e.alignSelf}),f.set(o,i)}return t(e.tag,Object(r["a"])(n,{class:i}),s)}})},6966:function(t,e,n){"use strict";n.r(e);var s=n("62ad"),r=n("a523"),a=n("0fd9"),o=function(){var t=this,e=t._self._c;return e(r["a"],{attrs:{fluid:"","ml-6":"","mt-6":""}},[e(a["a"],[e(s["a"],{attrs:{md:"4"}},[e("CustomCards",{attrs:{title:"New Booking",subtitle:t.newBooking,color:"#3859ff"}})],1),e(s["a"],{attrs:{md:"4"}},[e("CustomCards",{attrs:{title:"Check In",subtitle:t.checkin,color:"#79ba98"}})],1),e(s["a"],{attrs:{md:"4"}},[e("CustomCards",{attrs:{title:"Visitors (In month)",subtitle:t.visitors,color:"#c93b1e"}})],1)],1)],1)},i=[],l=function(){var t=this,e=t._self._c;return e("div",{staticClass:"box-card",style:t.cssProps},[e("h4",[t._v(t._s(t.title))]),e("p",{staticClass:"sub-title"},[t._v(t._s(t.subtitle))])])},c=[],u={name:"CustomCards",props:["title","subtitle","color"],computed:{cssProps(){return{"--color":this.color}}}},d=u,f=(n("46f0"),n("2877")),p=Object(f["a"])(d,l,c,!1,null,null,null),g=p.exports,b={components:{CustomCards:g},data(){return{newBooking:"",checkin:"",visitors:""}},mounted(){this.getVisitorData()},methods:{getVisitorData(){this.$axios.get("get-visitor-data").then(t=>{this.newBooking=t.data.newBooking,this.checkin=t.data.checkin,this.visitors=t.data.monthVisitors}).catch(t=>{throw t})}}},h=b,m=Object(f["a"])(h,o,i,!1,null,null,null);e["default"]=m.exports},a523:function(t,e,n){"use strict";n("20f6"),n("4b85");var s=n("e8f2"),r=n("d9f7");e["a"]=Object(s["a"])("container").extend({name:"v-container",functional:!0,props:{id:String,tag:{type:String,default:"div"},fluid:{type:Boolean,default:!1}},render(t,{props:e,data:n,children:s}){let a;const{attrs:o}=n;return o&&(n.attrs={},a=Object.keys(o).filter(t=>{if("slot"===t)return!1;const e=o[t];return t.startsWith("data-")?(n.attrs[t]=e,!1):e||"string"===typeof e})),e.id&&(n.domProps=n.domProps||{},n.domProps.id=e.id),t(e.tag,Object(r["a"])(n,{staticClass:"container",class:Array({"container--fluid":e.fluid}).concat(a||[])}),s)}})},e8f2:function(t,e,n){"use strict";n.d(e,"a",(function(){return r}));var s=n("2b0e");function r(t){return s["a"].extend({name:"v-"+t,functional:!0,props:{id:String,tag:{type:String,default:"div"}},render(e,{props:n,data:s,children:r}){s.staticClass=`${t} ${s.staticClass||""}`.trim();const{attrs:a}=s;if(a){s.attrs={};const t=Object.keys(a).filter(t=>{if("slot"===t)return!1;const e=a[t];return t.startsWith("data-")?(s.attrs[t]=e,!1):e||"string"===typeof e});t.length&&(s.staticClass+=" "+t.join(" "))}return n.id&&(s.domProps=s.domProps||{},s.domProps.id=n.id),e(n.tag,s,r)}})}}}]);