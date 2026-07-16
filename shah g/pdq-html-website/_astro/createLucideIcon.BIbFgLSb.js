import{a as E,r as u}from"./index.DK-fsZOb.js";var h={exports:{}},f={};/**
 * @license React
 * react-jsx-runtime.production.min.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */var C;function g(){if(C)return f;C=1;var t=E(),e=Symbol.for("react.element"),n=Symbol.for("react.fragment"),s=Object.prototype.hasOwnProperty,p=t.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,a={key:!0,ref:!0,__self:!0,__source:!0};function m(i,r,c){var o,l={},d=null,x=null;c!==void 0&&(d=""+c),r.key!==void 0&&(d=""+r.key),r.ref!==void 0&&(x=r.ref);for(o in r)s.call(r,o)&&!a.hasOwnProperty(o)&&(l[o]=r[o]);if(i&&i.defaultProps)for(o in r=i.defaultProps,r)l[o]===void 0&&(l[o]=r[o]);return{$$typeof:e,type:i,key:d,ref:x,props:l,_owner:p.current}}return f.Fragment=n,f.jsx=m,f.jsxs=m,f}var R;function L(){return R||(R=1,h.exports=g()),h.exports}var $=L();/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k=(...t)=>t.filter((e,n,s)=>!!e&&e.trim()!==""&&s.indexOf(e)===n).join(" ").trim();/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const S=t=>t.replace(/([a-z0-9])([A-Z])/g,"$1-$2").toLowerCase();/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A=t=>t.replace(/^([A-Z])|[\s-_]+(\w)/g,(e,n,s)=>s?s.toUpperCase():n.toLowerCase());/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const w=t=>{const e=A(t);return e.charAt(0).toUpperCase()+e.slice(1)};/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */var _={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor",strokeWidth:2,strokeLinecap:"round",strokeLinejoin:"round"};/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O=t=>{for(const e in t)if(e.startsWith("aria-")||e==="role"||e==="title")return!0;return!1},j=u.createContext({}),W=()=>u.useContext(j),q=u.forwardRef(({color:t,size:e,strokeWidth:n,absoluteStrokeWidth:s,className:p="",children:a,iconNode:m,...i},r)=>{const{size:c=24,strokeWidth:o=2,absoluteStrokeWidth:l=!1,color:d="currentColor",className:x=""}=W()??{},v=s??l?Number(n??o)*24/Number(e??c):n??o;return u.createElement("svg",{ref:r,..._,width:e??c??_.width,height:e??c??_.height,stroke:t??d,strokeWidth:v,className:k("lucide",x,p),...!a&&!O(i)&&{"aria-hidden":"true"},...i},[...m.map(([y,b])=>u.createElement(y,b)),...Array.isArray(a)?a:[a]])});/**
 * @license lucide-react v1.24.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I=(t,e)=>{const n=u.forwardRef(({className:s,...p},a)=>u.createElement(q,{ref:a,iconNode:e,className:k(`lucide-${S(w(t))}`,`lucide-${t}`,s),...p}));return n.displayName=w(t),n};export{I as c,$ as j};
