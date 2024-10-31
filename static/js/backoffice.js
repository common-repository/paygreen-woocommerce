/**
 * 2014 - 2023 Watt Is It
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License X11
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@paygreen.fr so we can send you a copy immediately.
 *
 * @author    PayGreen <contact@paygreen.fr>
 * @copyright 2014 - 2023 Watt Is It
 * @license   https://opensource.org/licenses/mit-license.php MIT License X11
 * @version   4.10.2
 *
 */
!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="../",r(r.s="mRj3")}({mRj3:function(e,t,r){"use strict";r.r(t);var n={openCSS:"js-open",handler:"tooltip",install:function(){for(var e=document.querySelectorAll('[data-js="'+n.handler+'"]'),t=0;t<e.length;t++)e[t].addEventListener("click",(function(){document.querySelector(this.dataset.target).classList.toggle(n.openCSS)}));document.body.addEventListener("click",(function(e){var t=e.target;t.classList.contains(n.openCSS)||n.getParentsClassLength(t)||t.dataset.js===n.handler||n.getParentsDataLength(t)||document.querySelectorAll(n.openCSS).forEach((function(e){e.classList.remove(n.openCSS)}))}))},getParentsClassLength:function(e){for(var t=0;e&&e!==document;e=e.parentNode)e.classList.contains(n.openCSS)&&t++;return t},getParentsDataLength:function(e){for(var t=0;e&&e!==document;e=e.parentNode)e.hasAttribute("data-js")&&e.dataset.js===n.handler&&t++;return t}},o=n,i={install:function(){var e=document.getElementById("shopSelect");null!==e&&e.addEventListener("change",(function(){this.value&&(window.location=this.value)}))}},a=r("zaRD");function s(e){return(s="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}var l={min:1,container:'[data-collection="container"]',install:function(){var e=this,t=document.querySelectorAll('[data-js="collection"]');Array.prototype.forEach.call(t,(function(t){e.setRemoveButtons(t),t.addEventListener("click",(function(t){e.process(t.target)}))}))},process:function(e){"remove"==e.dataset.collection?this.removeChild(e):"add"==e.dataset.collection&&this.addChild(e)},removeChild:function(e){var t=e.parentElement.parentElement;t.childElementCount>this.min&&e.parentElement.remove(),this.setRemoveButtons(t)},addChild:function(e){var t=e.parentElement.querySelector(this.container),r=t.lastElementChild.cloneNode(!0),n=r.dataset.collectionName,o=parseInt(r.dataset.collectionIndex),i=o+1,a=n+"["+o+"]",l=n+"["+i+"]";r.dataset.collectionIndex=i,t.appendChild(r),r.querySelectorAll("input, select, button").forEach((function(e){var t=e,r=t.getAttribute("name");t.value="",s(r)!==s(null)&&""!==r&&(r=r.replace(a,l),t.setAttribute("name",r))})),this.setRemoveButtons(t)},setRemoveButtons:function(e){var t=this,r=e.querySelectorAll('[data-collection="remove"]');Array.prototype.forEach.call(r,(function(r){r.disabled=e.childElementCount<=t.min}))}},c=function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")},u=function(){function e(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,r,n){return r&&e(t.prototype,r),n&&e(t,n),t}}(),p=function(e,t){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return function(e,t){var r=[],n=!0,o=!1,i=void 0;try{for(var a,s=e[Symbol.iterator]();!(n=(a=s.next()).done)&&(r.push(a.value),!t||r.length!==t);n=!0);}catch(e){o=!0,i=e}finally{try{!n&&s.return&&s.return()}finally{if(o)throw i}}return r}(e,t);throw new TypeError("Invalid attempt to destructure non-iterable instance")};String.prototype.startsWith=String.prototype.startsWith||function(e){return 0===this.indexOf(e)},String.prototype.padStart=String.prototype.padStart||function(e,t){for(var r=this;r.length<e;)r=t+r;return r};var d={cb:"0f8ff",tqw:"aebd7",q:"-ffff",qmrn:"7fffd4",zr:"0ffff",bg:"5f5dc",bsq:"e4c4",bck:"---",nch:"ebcd",b:"--ff",bvt:"8a2be2",brwn:"a52a2a",brw:"deb887",ctb:"5f9ea0",hrt:"7fff-",chcT:"d2691e",cr:"7f50",rnw:"6495ed",crns:"8dc",crms:"dc143c",cn:"-ffff",Db:"--8b",Dcn:"-8b8b",Dgnr:"b8860b",Dgr:"a9a9a9",Dgrn:"-64-",Dkhk:"bdb76b",Dmgn:"8b-8b",Dvgr:"556b2f",Drng:"8c-",Drch:"9932cc",Dr:"8b--",Dsmn:"e9967a",Dsgr:"8fbc8f",DsTb:"483d8b",DsTg:"2f4f4f",Dtrq:"-ced1",Dvt:"94-d3",ppnk:"1493",pskb:"-bfff",mgr:"696969",grb:"1e90ff",rbrc:"b22222",rwht:"af0",stg:"228b22",chs:"-ff",gnsb:"dcdcdc",st:"8f8ff",g:"d7-",gnr:"daa520",gr:"808080",grn:"-8-0",grnw:"adff2f",hnw:"0fff0",htpn:"69b4",nnr:"cd5c5c",ng:"4b-82",vr:"0",khk:"0e68c",vnr:"e6e6fa",nrb:"0f5",wngr:"7cfc-",mnch:"acd",Lb:"add8e6",Lcr:"08080",Lcn:"e0ffff",Lgnr:"afad2",Lgr:"d3d3d3",Lgrn:"90ee90",Lpnk:"b6c1",Lsmn:"a07a",Lsgr:"20b2aa",Lskb:"87cefa",LsTg:"778899",Lstb:"b0c4de",Lw:"e0",m:"-ff-",mgrn:"32cd32",nn:"af0e6",mgnt:"-ff",mrn:"8--0",mqm:"66cdaa",mmb:"--cd",mmrc:"ba55d3",mmpr:"9370db",msg:"3cb371",mmsT:"7b68ee","":"-fa9a",mtr:"48d1cc",mmvt:"c71585",mnLb:"191970",ntc:"5fffa",mstr:"e4e1",mccs:"e4b5",vjw:"dead",nv:"--80",c:"df5e6",v:"808-0",vrb:"6b8e23",rng:"a5-",rngr:"45-",rch:"da70d6",pgnr:"eee8aa",pgrn:"98fb98",ptrq:"afeeee",pvtr:"db7093",ppwh:"efd5",pchp:"dab9",pr:"cd853f",pnk:"c0cb",pm:"dda0dd",pwrb:"b0e0e6",prp:"8-080",cc:"663399",r:"--",sbr:"bc8f8f",rb:"4169e1",sbrw:"8b4513",smn:"a8072",nbr:"4a460",sgrn:"2e8b57",ssh:"5ee",snn:"a0522d",svr:"c0c0c0",skb:"87ceeb",sTb:"6a5acd",sTgr:"708090",snw:"afa",n:"-ff7f",stb:"4682b4",tn:"d2b48c",t:"-8080",thst:"d8bfd8",tmT:"6347",trqs:"40e0d0",vt:"ee82ee",whT:"5deb3",wht:"",hts:"5f5f5",w:"-",wgrn:"9acd32"};function f(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1,r=t>0?e.toFixed(t).replace(/0+$/,"").replace(/\.$/,""):e.toString();return r||"0"}var h=function(){function e(t,r,n,o){c(this,e);var i=this;if(void 0===t);else if(Array.isArray(t))this.rgba=t;else if(void 0===n){var a=t&&""+t;a&&function(t){if(t.startsWith("hsl")){var r=t.match(/([\-\d\.e]+)/g).map(Number),n=p(r,4),o=n[0],a=n[1],s=n[2],l=n[3];void 0===l&&(l=1),o/=360,a/=100,s/=100,i.hsla=[o,a,s,l]}else if(t.startsWith("rgb")){var c=t.match(/([\-\d\.e]+)/g).map(Number),u=p(c,4),d=u[0],f=u[1],h=u[2],g=u[3];void 0===g&&(g=1),i.rgba=[d,f,h,g]}else t.startsWith("#")?i.rgba=e.hexToRgb(t):i.rgba=e.nameToRgb(t)||e.hexToRgb(t)}(a.toLowerCase())}else this.rgba=[t,r,n,void 0===o?1:o]}return u(e,[{key:"printRGB",value:function(e){var t=(e?this.rgba:this.rgba.slice(0,3)).map((function(e,t){return f(e,3===t?3:0)}));return e?"rgba("+t+")":"rgb("+t+")"}},{key:"printHSL",value:function(e){var t=[360,100,100,1],r=["","%","%",""],n=(e?this.hsla:this.hsla.slice(0,3)).map((function(e,n){return f(e*t[n],3===n?3:1)+r[n]}));return e?"hsla("+n+")":"hsl("+n+")"}},{key:"printHex",value:function(e){var t=this.hex;return e?t:t.substring(0,7)}},{key:"rgba",get:function(){if(this._rgba)return this._rgba;if(!this._hsla)throw new Error("No color is set");return this._rgba=e.hslToRgb(this._hsla)},set:function(e){3===e.length&&(e[3]=1),this._rgba=e,this._hsla=null}},{key:"rgbString",get:function(){return this.printRGB()}},{key:"rgbaString",get:function(){return this.printRGB(!0)}},{key:"hsla",get:function(){if(this._hsla)return this._hsla;if(!this._rgba)throw new Error("No color is set");return this._hsla=e.rgbToHsl(this._rgba)},set:function(e){3===e.length&&(e[3]=1),this._hsla=e,this._rgba=null}},{key:"hslString",get:function(){return this.printHSL()}},{key:"hslaString",get:function(){return this.printHSL(!0)}},{key:"hex",get:function(){return"#"+this.rgba.map((function(e,t){return t<3?e.toString(16):Math.round(255*e).toString(16)})).map((function(e){return e.padStart(2,"0")})).join("")},set:function(t){this.rgba=e.hexToRgb(t)}}],[{key:"hexToRgb",value:function(e){var t=(e.startsWith("#")?e.slice(1):e).replace(/^(\w{3})$/,"$1F").replace(/^(\w)(\w)(\w)(\w)$/,"$1$1$2$2$3$3$4$4").replace(/^(\w{6})$/,"$1FF");if(!t.match(/^([0-9a-fA-F]{8})$/))throw new Error("Unknown hex color; "+e);var r=t.match(/^(\w\w)(\w\w)(\w\w)(\w\w)$/).slice(1).map((function(e){return parseInt(e,16)}));return r[3]=r[3]/255,r}},{key:"nameToRgb",value:function(t){var r=t.toLowerCase().replace("at","T").replace(/[aeiouyldf]/g,"").replace("ght","L").replace("rk","D").slice(-5,4),n=d[r];return void 0===n?n:e.hexToRgb(n.replace(/\-/g,"00").padStart(6,"f"))}},{key:"rgbToHsl",value:function(e){var t=p(e,4),r=t[0],n=t[1],o=t[2],i=t[3];r/=255,n/=255,o/=255;var a=Math.max(r,n,o),s=Math.min(r,n,o),l=void 0,c=void 0,u=(a+s)/2;if(a===s)l=c=0;else{var d=a-s;switch(c=u>.5?d/(2-a-s):d/(a+s),a){case r:l=(n-o)/d+(n<o?6:0);break;case n:l=(o-r)/d+2;break;case o:l=(r-n)/d+4}l/=6}return[l,c,u,i]}},{key:"hslToRgb",value:function(e){var t=p(e,4),r=t[0],n=t[1],o=t[2],i=t[3],a=void 0,s=void 0,l=void 0;if(0===n)a=s=l=o;else{var c=function(e,t,r){return r<0&&(r+=1),r>1&&(r-=1),r<1/6?e+6*(t-e)*r:r<.5?t:r<2/3?e+(t-e)*(2/3-r)*6:e},u=o<.5?o*(1+n):o+n-o*n,d=2*o-u;a=c(d,u,r+1/3),s=c(d,u,r),l=c(d,u,r-1/3)}var f=[255*a,255*s,255*l].map(Math.round);return f[3]=i,f}}]),e}(),g=function(){function e(){c(this,e),this._events=[]}return u(e,[{key:"add",value:function(e,t,r){e.addEventListener(t,r,!1),this._events.push({target:e,type:t,handler:r})}},{key:"remove",value:function(t,r,n){this._events=this._events.filter((function(o){var i=!0;return t&&t!==o.target&&(i=!1),r&&r!==o.type&&(i=!1),n&&n!==o.handler&&(i=!1),i&&e._doRemove(o.target,o.type,o.handler),!i}))}},{key:"destroy",value:function(){this._events.forEach((function(t){return e._doRemove(t.target,t.type,t.handler)})),this._events=[]}}],[{key:"_doRemove",value:function(e,t,r){e.removeEventListener(t,r,!1)}}]),e}();function m(e,t,r){var n=!1;function o(e,t,r){return Math.max(t,Math.min(e,r))}function i(e,i,a){if(a&&(n=!0),n){e.preventDefault();var s=t.getBoundingClientRect(),l=s.width,c=s.height,u=i.clientX,p=i.clientY,d=o(u-s.left,0,l),f=o(p-s.top,0,c);r(d/l,f/c)}}function a(e,t){1===(void 0===e.buttons?e.which:e.buttons)?i(e,e,t):n=!1}function s(e,t){1===e.touches.length?i(e,e.touches[0],t):n=!1}e.add(t,"mousedown",(function(e){a(e,!0)})),e.add(t,"touchstart",(function(e){s(e,!0)})),e.add(window,"mousemove",a),e.add(t,"touchmove",s),e.add(window,"mouseup",(function(e){n=!1})),e.add(t,"touchend",(function(e){n=!1})),e.add(t,"touchcancel",(function(e){n=!1}))}function b(e,t){return(t||document).querySelector(e)}function v(e){e.preventDefault(),e.stopPropagation()}function _(e,t,r,n,o){e.add(t,"keydown",(function(e){r.indexOf(e.key)>=0&&(o&&v(e),n(e))}))}var y=function(){function e(t){c(this,e),this.settings={popup:"right",layout:"default",alpha:!0,editor:!0,editorFormat:"hex",cancelButton:!1,defaultColor:"#0cf"},this._events=new g,this.onChange=null,this.onDone=null,this.onOpen=null,this.onClose=null,this.setOptions(t)}return u(e,[{key:"setOptions",value:function(e){var t=this;if(e){var r=this.settings;if(e instanceof HTMLElement)r.parent=e;else{r.parent&&e.parent&&r.parent!==e.parent&&(this._events.remove(r.parent),this._popupInited=!1),function(e,t,r){for(var n in e)r&&r.indexOf(n)>=0||(t[n]=e[n])}(e,r),e.onChange&&(this.onChange=e.onChange),e.onDone&&(this.onDone=e.onDone),e.onOpen&&(this.onOpen=e.onOpen),e.onClose&&(this.onClose=e.onClose);var n=e.color||e.colour;n&&this._setColor(n)}var o=r.parent;if(o&&r.popup&&!this._popupInited){var i=function(e){return t.openHandler(e)};this._events.add(o,"click",i),_(this._events,o,[" ","Spacebar","Enter"],i),this._popupInited=!0}else e.parent&&!r.popup&&this.show()}}},{key:"openHandler",value:function(e){if(this.show()){e&&e.preventDefault(),this.settings.parent.style.pointerEvents="none";var t=e&&"keydown"===e.type?this._domEdit:this.domElement;setTimeout((function(){return t.focus()}),100),this.onOpen&&this.onOpen(this.colour)}}},{key:"closeHandler",value:function(e){var t=e&&e.type,r=!1;if(e)if("mousedown"===t||"focusin"===t){var n=(this.__containedEvent||0)+100;e.timeStamp>n&&(r=!0)}else v(e),r=!0;else r=!0;r&&this.hide()&&(this.settings.parent.style.pointerEvents="","mousedown"!==t&&this.settings.parent.focus(),this.onClose&&this.onClose(this.colour))}},{key:"movePopup",value:function(e,t){this.closeHandler(),this.setOptions(e),t&&this.openHandler()}},{key:"setColor",value:function(e,t){this._setColor(e,{silent:t})}},{key:"_setColor",value:function(e,t){if("string"==typeof e&&(e=e.trim()),e){t=t||{};var r=void 0;try{r=new h(e)}catch(e){if(t.failSilently)return;throw e}if(!this.settings.alpha){var n=r.hsla;n[3]=1,r.hsla=n}this.colour=this.color=r,this._setHSLA(null,null,null,null,t)}}},{key:"setColour",value:function(e,t){this.setColor(e,t)}},{key:"show",value:function(){if(!this.settings.parent)return!1;if(this.domElement){var e=this._toggleDOM(!0);return this._setPosition(),e}var t,r,n=this.settings.template||'<div class="picker_wrapper" tabindex="-1"><div class="picker_arrow"></div><div class="picker_hue picker_slider"><div class="picker_selector"></div></div><div class="picker_sl"><div class="picker_selector"></div></div><div class="picker_alpha picker_slider"><div class="picker_selector"></div></div><div class="picker_editor"><input aria-label="Type a color name or hex value"/></div><div class="picker_sample"></div><div class="picker_done"><button>Ok</button></div><div class="picker_cancel"><button>Cancel</button></div></div>',o=(t=n,(r=document.createElement("div")).innerHTML=t,r.firstElementChild);return this.domElement=o,this._domH=b(".picker_hue",o),this._domSL=b(".picker_sl",o),this._domA=b(".picker_alpha",o),this._domEdit=b(".picker_editor input",o),this._domSample=b(".picker_sample",o),this._domOkay=b(".picker_done button",o),this._domCancel=b(".picker_cancel button",o),o.classList.add("layout_"+this.settings.layout),this.settings.alpha||o.classList.add("no_alpha"),this.settings.editor||o.classList.add("no_editor"),this.settings.cancelButton||o.classList.add("no_cancel"),this._ifPopup((function(){return o.classList.add("popup")})),this._setPosition(),this.colour?this._updateUI():this._setColor(this.settings.defaultColor),this._bindEvents(),!0}},{key:"hide",value:function(){return this._toggleDOM(!1)}},{key:"destroy",value:function(){this._events.destroy(),this.domElement&&this.settings.parent.removeChild(this.domElement)}},{key:"_bindEvents",value:function(){var e=this,t=this,r=this.domElement,n=this._events;function o(e,t,r){n.add(e,t,r)}o(r,"click",(function(e){return e.preventDefault()})),m(n,this._domH,(function(e,r){return t._setHSLA(e)})),m(n,this._domSL,(function(e,r){return t._setHSLA(null,e,1-r)})),this.settings.alpha&&m(n,this._domA,(function(e,r){return t._setHSLA(null,null,null,1-r)}));var i=this._domEdit;o(i,"input",(function(e){t._setColor(this.value,{fromEditor:!0,failSilently:!0})})),o(i,"focus",(function(e){this.selectionStart===this.selectionEnd&&this.select()})),this._ifPopup((function(){var t=function(t){return e.closeHandler(t)};o(window,"mousedown",t),o(window,"focusin",t),_(n,r,["Esc","Escape"],t);var i=function(t){e.__containedEvent=t.timeStamp};o(r,"mousedown",i),o(r,"focusin",i),o(e._domCancel,"click",t)}));var a=function(t){e._ifPopup((function(){return e.closeHandler(t)})),e.onDone&&e.onDone(e.colour)};o(this._domOkay,"click",a),_(n,r,["Enter"],a)}},{key:"_setPosition",value:function(){var e=this.settings.parent,t=this.domElement;e!==t.parentNode&&e.appendChild(t),this._ifPopup((function(r){"static"===getComputedStyle(e).position&&(e.style.position="relative");var n=!0===r?"popup_right":"popup_"+r;["popup_top","popup_bottom","popup_left","popup_right"].forEach((function(e){e===n?t.classList.add(e):t.classList.remove(e)})),t.classList.add(n)}))}},{key:"_setHSLA",value:function(e,t,r,n,o){o=o||{};var i=this.colour,a=i.hsla;[e,t,r,n].forEach((function(e,t){(e||0===e)&&(a[t]=e)})),i.hsla=a,this._updateUI(o),this.onChange&&!o.silent&&this.onChange(i)}},{key:"_updateUI",value:function(e){if(this.domElement){e=e||{};var t=this.colour,r=t.hsla,n="hsl("+360*r[0]+", 100%, 50%)",o=t.hslString,i=t.hslaString,a=this._domH,s=this._domSL,l=this._domA,c=b(".picker_selector",a),u=b(".picker_selector",s),p=b(".picker_selector",l);_(0,c,r[0]),this._domSL.style.backgroundColor=this._domH.style.color=n,_(0,u,r[1]),y(0,u,1-r[2]),s.style.color=o,y(0,p,1-r[3]);var d=o,f=d.replace("hsl","hsla").replace(")",", 0)"),h="linear-gradient("+[d,f]+")";if(this._domA.style.background=h+", linear-gradient(45deg, lightgrey 25%, transparent 25%, transparent 75%, lightgrey 75%) 0 0 / 2em 2em,\n                   linear-gradient(45deg, lightgrey 25%,       white 25%,       white 75%, lightgrey 75%) 1em 1em / 2em 2em",!e.fromEditor){var g=this.settings.editorFormat,m=this.settings.alpha,v=void 0;switch(g){case"rgb":v=t.printRGB(m);break;case"hsl":v=t.printHSL(m);break;default:v=t.printHex(m)}this._domEdit.value=v}this._domSample.style.color=i}function _(e,t,r){t.style.left=100*r+"%"}function y(e,t,r){t.style.top=100*r+"%"}}},{key:"_ifPopup",value:function(e,t){this.settings.parent&&this.settings.popup?e&&e(this.settings.popup):t&&t()}},{key:"_toggleDOM",value:function(e){var t=this.domElement;if(!t)return!1;var r=e?"":"none",n=t.style.display!==r;return n&&(t.style.display=r),n}}]),e}(),k=document.createElement("style");function w(e,t){var r="undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(!r){if(Array.isArray(e)||(r=function(e,t){if(!e)return;if("string"==typeof e)return S(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return S(e,t)}(e))||t&&e&&"number"==typeof e.length){r&&(e=r);var n=0,o=function(){};return{s:o,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,a=!0,s=!1;return{s:function(){r=r.call(e)},n:function(){var e=r.next();return a=e.done,e},e:function(e){s=!0,i=e},f:function(){try{a||null==r.return||r.return()}finally{if(s)throw i}}}}function S(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}k.textContent='.picker_wrapper.no_alpha .picker_alpha{display:none}.picker_wrapper.no_editor .picker_editor{position:absolute;z-index:-1;opacity:0}.picker_wrapper.no_cancel .picker_cancel{display:none}.layout_default.picker_wrapper{display:flex;flex-flow:row wrap;justify-content:space-between;align-items:stretch;font-size:10px;width:25em;padding:.5em}.layout_default.picker_wrapper input,.layout_default.picker_wrapper button{font-size:1rem}.layout_default.picker_wrapper>*{margin:.5em}.layout_default.picker_wrapper::before{content:"";display:block;width:100%;height:0;order:1}.layout_default .picker_slider,.layout_default .picker_selector{padding:1em}.layout_default .picker_hue{width:100%}.layout_default .picker_sl{flex:1 1 auto}.layout_default .picker_sl::before{content:"";display:block;padding-bottom:100%}.layout_default .picker_editor{order:1;width:6.5rem}.layout_default .picker_editor input{width:100%;height:100%}.layout_default .picker_sample{order:1;flex:1 1 auto}.layout_default .picker_done,.layout_default .picker_cancel{order:1}.picker_wrapper{box-sizing:border-box;background:#f2f2f2;box-shadow:0 0 0 1px silver;cursor:default;font-family:sans-serif;color:#444;pointer-events:auto}.picker_wrapper:focus{outline:none}.picker_wrapper button,.picker_wrapper input{box-sizing:border-box;border:none;box-shadow:0 0 0 1px silver;outline:none}.picker_wrapper button:focus,.picker_wrapper button:active,.picker_wrapper input:focus,.picker_wrapper input:active{box-shadow:0 0 2px 1px #1e90ff}.picker_wrapper button{padding:.4em .6em;cursor:pointer;background-color:#f5f5f5;background-image:linear-gradient(0deg, gainsboro, transparent)}.picker_wrapper button:active{background-image:linear-gradient(0deg, transparent, gainsboro)}.picker_wrapper button:hover{background-color:#fff}.picker_selector{position:absolute;z-index:1;display:block;-webkit-transform:translate(-50%, -50%);transform:translate(-50%, -50%);border:2px solid #fff;border-radius:100%;box-shadow:0 0 3px 1px #67b9ff;background:currentColor;cursor:pointer}.picker_slider .picker_selector{border-radius:2px}.picker_hue{position:relative;background-image:linear-gradient(90deg, red, yellow, lime, cyan, blue, magenta, red);box-shadow:0 0 0 1px silver}.picker_sl{position:relative;box-shadow:0 0 0 1px silver;background-image:linear-gradient(180deg, white, rgba(255, 255, 255, 0) 50%),linear-gradient(0deg, black, rgba(0, 0, 0, 0) 50%),linear-gradient(90deg, #808080, rgba(128, 128, 128, 0))}.picker_alpha,.picker_sample{position:relative;background:linear-gradient(45deg, lightgrey 25%, transparent 25%, transparent 75%, lightgrey 75%) 0 0/2em 2em,linear-gradient(45deg, lightgrey 25%, white 25%, white 75%, lightgrey 75%) 1em 1em/2em 2em;box-shadow:0 0 0 1px silver}.picker_alpha .picker_selector,.picker_sample .picker_selector{background:none}.picker_editor input{font-family:monospace;padding:.2em .4em}.picker_sample::before{content:"";position:absolute;display:block;width:100%;height:100%;background:currentColor}.picker_arrow{position:absolute;z-index:-1}.picker_wrapper.popup{position:absolute;z-index:2;margin:1.5em}.picker_wrapper.popup,.picker_wrapper.popup .picker_arrow::before,.picker_wrapper.popup .picker_arrow::after{background:#f2f2f2;box-shadow:0 0 10px 1px rgba(0,0,0,.4)}.picker_wrapper.popup .picker_arrow{width:3em;height:3em;margin:0}.picker_wrapper.popup .picker_arrow::before,.picker_wrapper.popup .picker_arrow::after{content:"";display:block;position:absolute;top:0;left:0;z-index:-99}.picker_wrapper.popup .picker_arrow::before{width:100%;height:100%;-webkit-transform:skew(45deg);transform:skew(45deg);-webkit-transform-origin:0 100%;transform-origin:0 100%}.picker_wrapper.popup .picker_arrow::after{width:150%;height:150%;box-shadow:none}.popup.popup_top{bottom:100%;left:0}.popup.popup_top .picker_arrow{bottom:0;left:0;-webkit-transform:rotate(-90deg);transform:rotate(-90deg)}.popup.popup_bottom{top:100%;left:0}.popup.popup_bottom .picker_arrow{top:0;left:0;-webkit-transform:rotate(90deg) scale(1, -1);transform:rotate(90deg) scale(1, -1)}.popup.popup_left{top:0;right:100%}.popup.popup_left .picker_arrow{top:0;right:0;-webkit-transform:scale(-1, 1);transform:scale(-1, 1)}.popup.popup_right{top:0;left:100%}.popup.popup_right .picker_arrow{top:0;left:0}',document.documentElement.firstElementChild.appendChild(k),y.StyleElement=k;var x={install:function(){this.handleColorPicker()},handleColorPicker:function(){var e,t=w(document.querySelectorAll('[data-js="colorpicker"]'));try{var r=function(){var t=e.value,r=t.closest(".pgform__field__colorpicker__container");new y({parent:r,color:t.value,editorFormat:"hex",onChange:function(e){var r=e.hex;t.setAttribute("value",r),t.style.backgroundColor=r;var n=t.id.concat("onChange"),o=new Event(n);t.dispatchEvent(o)}})};for(t.s();!(e=t.n()).done;)r()}catch(e){t.e(e)}finally{t.f()}}},C={'[data-js="collection"]':l},E={install:function(){for(var e in C)C.hasOwnProperty(e)&&e.length>=1&&C[e].install();o.install(),i.install(),x.install(),a.default.install()}};window.addEventListener("DOMContentLoaded",(function(e){E.install()}))},zaRD:function(e,t,r){"use strict";function n(e,t){var r="undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(!r){if(Array.isArray(e)||(r=function(e,t){if(!e)return;if("string"==typeof e)return o(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return o(e,t)}(e))||t&&e&&"number"==typeof e.length){r&&(e=r);var n=0,i=function(){};return{s:i,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:i}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var a,s=!0,l=!1;return{s:function(){r=r.call(e)},n:function(){var e=r.next();return s=e.done,e},e:function(e){l=!0,a=e},f:function(){try{s||null==r.return||r.return()}finally{if(l)throw a}}}}function o(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}r.r(t);e={install:function(){this.handleConfirmation()},handleConfirmation:function(){var e,t=n(document.querySelectorAll("[data-confirm]"));try{for(t.s();!(e=t.n()).done;){var r=e.value;void 0!==r.dataset.confirm&&r.addEventListener("click",(function(e){confirm(e.target.dataset.message)||e.preventDefault()}))}}catch(e){t.e(e)}finally{t.f()}}};t.default=e}});