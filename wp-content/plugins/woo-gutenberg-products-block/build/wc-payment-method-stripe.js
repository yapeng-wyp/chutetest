!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=10)}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wc.wcSettings},function(e,t,r){!function(e,t){"use strict";function r(){}function n(){}t=t&&Object.prototype.hasOwnProperty.call(t,"default")?t.default:t,n.resetWarningCache=r;var o=function(e,t){return function(e){e.exports=function(){function e(e,t,r,n,o,a){if("SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"!==a){var c=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw c.name="Invariant Violation",c}}function t(){return e}e.isRequired=e;var o={array:e,bool:e,func:e,number:e,object:e,string:e,symbol:e,any:e,arrayOf:t,element:e,elementType:e,instanceOf:t,node:e,objectOf:t,oneOf:t,oneOfType:t,shape:t,exact:t,checkPropTypes:n,resetWarningCache:r};return o.PropTypes=o,o}()}(t={exports:{}}),t.exports}();function a(e){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function c(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}function s(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function i(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?s(Object(r),!0).forEach((function(t){c(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):s(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function l(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var u=function(e){var r=t.useRef(e);return t.useEffect((function(){r.current=e}),[e]),r.current},p=function(e){return null!==e&&"object"===a(e)},d=function(e,t,r){return p(e)?Object.keys(e).reduce((function(n,o){var a=!p(t)||!function e(t,r){if(!p(t)||!p(r))return t===r;var n=Array.isArray(t);if(n!==Array.isArray(r))return!1;var o="[object Object]"===Object.prototype.toString.call(t);if(o!==("[object Object]"===Object.prototype.toString.call(r)))return!1;if(!o&&!n)return!1;var a=Object.keys(t),c=Object.keys(r);if(a.length!==c.length)return!1;for(var s={},i=0;i<a.length;i+=1)s[a[i]]=!0;for(var l=0;l<c.length;l+=1)s[c[l]]=!0;var u=Object.keys(s);if(u.length!==a.length)return!1;var d=t,m=r;return u.every((function(t){return e(d[t],m[t])}))}(e[o],t[o]);return r.includes(o)?(a&&console.warn("Unsupported prop change: options.".concat(o," is not a mutable property.")),n):a?i(i({},n||{}),{},c({},o,e[o])):n}),null):null},m=function(e){if(null===e||p(t=e)&&"function"==typeof t.elements&&"function"==typeof t.createToken&&"function"==typeof t.createPaymentMethod&&"function"==typeof t.confirmCardPayment)return e;var t;throw new Error("Invalid prop `stripe` supplied to `Elements`. We recommend using the `loadStripe` utility from `@stripe/stripe-js`. See https://stripe.com/docs/stripe-js/react#elements-props-stripe for details.")},y=t.createContext(null);y.displayName="ElementsContext";var f=function(e){var r,n,o=e.stripe,a=e.options,c=e.children,s=t.useRef(!1),i=t.useRef(!0),f=t.useMemo((function(){return function(e){if(function(e){return p(e)&&"function"==typeof e.then}(e))return{tag:"async",stripePromise:Promise.resolve(e).then(m)};var t=m(e);return null===t?{tag:"empty"}:{tag:"sync",stripe:t}}(o)}),[o]),b=(r=t.useState((function(){return{stripe:null,elements:null}})),n=2,function(e){if(Array.isArray(e))return e}(r)||function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var r=[],_n=!0,n=!1,o=void 0;try{for(var a,c=e[Symbol.iterator]();!(_n=(a=c.next()).done)&&(r.push(a.value),!t||r.length!==t);_n=!0);}catch(e){n=!0,o=e}finally{try{_n||null==c.return||c.return()}finally{if(n)throw o}}return r}}(r,n)||function(e,t){if(e){if("string"==typeof e)return l(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?l(e,t):void 0}}(r,n)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()),g=b[0],h=b[1],E=u(o);null!==E&&E!==o&&console.warn("Unsupported prop change on Elements: You cannot change the `stripe` prop after setting it."),s.current||("sync"===f.tag&&(s.current=!0,h({stripe:f.stripe,elements:f.stripe.elements(a)})),"async"===f.tag&&(s.current=!0,f.stripePromise.then((function(e){e&&i.current&&h({stripe:e,elements:e.elements(a)})}))));var v=u(a);return t.useEffect((function(){if(g.elements){var e=d(a,v,["clientSecret","fonts"]);e&&g.elements.update(e)}}),[a,v,g.elements]),t.useEffect((function(){return function(){i.current=!1}}),[]),t.useEffect((function(){var e=g.stripe;e&&e._registerWrapper&&e.registerAppInfo&&(e._registerWrapper({name:"react-stripe-js",version:"1.6.0"}),e.registerAppInfo({name:"react-stripe-js",version:"1.6.0",url:"https://stripe.com/docs/stripe-js/react"}))}),[g.stripe]),t.createElement(y.Provider,{value:g},c)};f.propTypes={stripe:o.any,options:o.object};var b=function(e){return function(e,t){if(!e)throw new Error("Could not find Elements context; You need to wrap the part of your app that ".concat(t," in an <Elements> provider."));return e}(t.useContext(y),e)},g=function(e){return(0,e.children)(b("mounts <ElementsConsumer>"))};g.propTypes={children:o.func.isRequired};var h=function(e){var r=t.useRef(e);return t.useEffect((function(){r.current=e}),[e]),function(){r.current&&r.current.apply(r,arguments)}},E=function(){},v=function(e,r){var n,a="".concat((n=e).charAt(0).toUpperCase()+n.slice(1),"Element"),c=r?function(e){b("mounts <".concat(a,">"));var r=e.id,n=e.className;return t.createElement("div",{id:r,className:n})}:function(r){var n=r.id,o=r.className,c=r.options,s=void 0===c?{}:c,i=r.onBlur,l=void 0===i?E:i,p=r.onFocus,m=void 0===p?E:p,y=r.onReady,f=void 0===y?E:y,g=r.onChange,v=void 0===g?E:g,O=r.onEscape,w=void 0===O?E:O,C=r.onClick,_=void 0===C?E:C,j=b("mounts <".concat(a,">")).elements,R=t.useRef(null),S=t.useRef(null),P=h(f),T=h(l),A=h(m),x=h(_),k=h(v),I=h(w);t.useLayoutEffect((function(){if(null==R.current&&j&&null!=S.current){var t=j.create(e,s);R.current=t,t.mount(S.current),t.on("ready",(function(){return P(t)})),t.on("change",k),t.on("blur",T),t.on("focus",A),t.on("escape",I),t.on("click",x)}}));var M=u(s);return t.useEffect((function(){if(R.current){var e=d(s,M,["paymentRequest"]);e&&R.current.update(e)}}),[s,M]),t.useLayoutEffect((function(){return function(){R.current&&R.current.destroy()}}),[]),t.createElement("div",{id:n,className:o,ref:S})};return c.propTypes={id:o.string,className:o.string,onChange:o.func,onBlur:o.func,onFocus:o.func,onReady:o.func,onClick:o.func,options:o.object},c.displayName=a,c.__elementType=e,c},O="undefined"==typeof window,w=v("auBankAccount",O),C=v("card",O),_=v("cardNumber",O),j=v("cardExpiry",O),R=v("cardCvc",O),S=v("fpxBank",O),P=v("iban",O),T=v("idealBank",O),A=v("p24Bank",O),x=v("epsBank",O),k=v("payment",O),I=v("paymentRequestButton",O),M=v("linkAuthentication",O),q=v("shippingAddress",O),N=v("afterpayClearpayMessage",O);e.AfterpayClearpayMessageElement=N,e.AuBankAccountElement=w,e.CardCvcElement=R,e.CardElement=C,e.CardExpiryElement=j,e.CardNumberElement=_,e.Elements=f,e.ElementsConsumer=g,e.EpsBankElement=x,e.FpxBankElement=S,e.IbanElement=P,e.IdealBankElement=T,e.LinkAuthenticationElement=M,e.P24BankElement=A,e.PaymentElement=k,e.PaymentRequestButtonElement=I,e.ShippingAddressElement=q,e.useElements=function(){return b("calls useElements()").elements},e.useStripe=function(){return b("calls useStripe()").stripe},Object.defineProperty(e,"__esModule",{value:!0})}(t,r(9))},,function(e,t){e.exports=window.wc.wcBlocksRegistry},,function(e,t){function r(){return e.exports=r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e},e.exports.default=e.exports,e.exports.__esModule=!0,r.apply(this,arguments)}e.exports=r,e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t){e.exports=window.wp.isShallowEqual},function(e,t){e.exports=window.React},function(e,t,r){"use strict";r.r(t);var n=r(5),o=r(7),a=r.n(o),c=r(0),s=r(1),i="https://js.stripe.com/v3",l=/^https:\/\/js\.stripe\.com\/v3\/?(\?.*)?$/,u="loadStripe.setLoadParameters was called but an existing Stripe.js script already exists in the document; existing script parameters will be used",p=null,d=function(e,t,r){if(null===e)return null;var n=e.apply(void 0,t);return function(e,t){e&&e._registerWrapper&&e._registerWrapper({name:"stripe-js",version:"1.16.0",startTime:t})}(n,r),n},m=Promise.resolve().then((function(){return e=null,null!==p?p:p=new Promise((function(t,r){if("undefined"!=typeof window)if(window.Stripe&&e&&console.warn(u),window.Stripe)t(window.Stripe);else try{var n=function(){for(var e=document.querySelectorAll('script[src^="'.concat(i,'"]')),t=0;t<e.length;t++){var r=e[t];if(l.test(r.src))return r}return null}();n&&e?console.warn(u):n||(n=function(e){var t=e&&!e.advancedFraudSignals?"?advancedFraudSignals=false":"",r=document.createElement("script");r.src="".concat(i).concat(t);var n=document.head||document.body;if(!n)throw new Error("Expected document.body not to be null. Stripe.js requires a <body> element.");return n.appendChild(r),r}(e)),n.addEventListener("load",(function(){window.Stripe?t(window.Stripe):r(new Error("Stripe.js not available"))})),n.addEventListener("error",(function(){r(new Error("Failed to load Stripe.js"))}))}catch(e){return void r(e)}else t(null)}));var e})),y=!1;m.catch((function(e){y||console.warn(e)}));var f=r(2);const b=function(e){let t=arguments.length>1&&void 0!==arguments[1]&&arguments[1];return e.map(e=>!!e.value&&{amount:e.value,label:e.label,pending:t}).filter(Boolean)},g=e=>e[0].shipping_rates.map(e=>({id:e.rate_id,label:e.name,detail:e.description,amount:parseInt(e.price,10)})),h=e=>({first_name:e.recipient.split(" ").slice(0,1).join(" "),last_name:e.recipient.split(" ").slice(1).join(" "),company:"",address_1:void 0===e.addressLine[0]?"":e.addressLine[0],address_2:void 0===e.addressLine[1]?"":e.addressLine[1],city:e.city,state:e.region,country:e.country,postcode:e.postalCode.replace(" ","")}),E=e=>{const t=e.source,r=t&&t.owner.name,n=t&&t.owner.address,o=e.payerEmail||"",a=e.payerPhone||"";return{first_name:r?r.split(" ").slice(0,1).join(" "):"",last_name:r?r.split(" ").slice(1).join(" "):"",email:t&&t.owner.email||o,phone:t&&t.owner.phone||a.replace("/[() -]/g",""),country:n&&n.country||"",address_1:n&&n.line1||"",address_2:n&&n.line2||"",city:n&&n.city||"",state:n&&n.state||"",postcode:n&&n.postal_code||"",company:""}},v=(e,t)=>({payment_method:"stripe",stripe_source:e.source?e.source.id:null,payment_request_type:t}),O={INVALID_EMAIL:"email_invalid",INVALID_REQUEST:"invalid_request_error",API_CONNECTION:"api_connection_error",API_ERROR:"api_error",AUTHENTICATION_ERROR:"authentication_error",RATE_LIMIT_ERROR:"rate_limit_error",CARD_ERROR:"card_error",VALIDATION_ERROR:"validation_error"},w=()=>{const e=Object(f.getSetting)("stripe_data",null);if(!e)throw new Error("Stripe initialization data is not available");return e},C=e=>({label:w().stripeTotalLabel||Object(s.__)("Total","woo-gutenberg-products-block"),amount:e.value}),_=e=>[O.INVALID_REQUEST,O.API_CONNECTION,O.API_ERROR,O.AUTHENTICATION_ERROR,O.RATE_LIMIT_ERROR].includes(e),j=e=>({invalid_number:Object(s.__)("The card number is not a valid credit card number.","woocommerce-gateway-stripe"),invalid_expiry_month:Object(s.__)("The card expiration month is invalid.","woocommerce-gateway-stripe"),invalid_expiry_year:Object(s.__)("The card expiration year is invalid.","woocommerce-gateway-stripe"),invalid_cvc:Object(s.__)("The card security code is invalid.","woocommerce-gateway-stripe"),incorrect_number:Object(s.__)("The card number is incorrect.","woocommerce-gateway-stripe"),incomplete_number:Object(s.__)("The card number is incomplete.","woocommerce-gateway-stripe"),incomplete_cvc:Object(s.__)("The card security code is incomplete.","woocommerce-gateway-stripe"),incomplete_expiry:Object(s.__)("The card expiration date is incomplete.","woocommerce-gateway-stripe"),expired_card:Object(s.__)("The card has expired.","woocommerce-gateway-stripe"),incorrect_cvc:Object(s.__)("The card security code is incorrect.","woocommerce-gateway-stripe"),incorrect_zip:Object(s.__)("The card zip code failed validation.","woocommerce-gateway-stripe"),invalid_expiry_year_past:Object(s.__)("The card expiration year is in the past","woocommerce-gateway-stripe"),card_declined:Object(s.__)("The card was declined.","woocommerce-gateway-stripe"),missing:Object(s.__)("There is no card on a customer that is being charged.","woocommerce-gateway-stripe"),processing_error:Object(s.__)("An error occurred while processing the card.","woocommerce-gateway-stripe")}[e]||null),R=function(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";switch(e){case O.INVALID_EMAIL:return Object(s.__)("Invalid email address, please correct and try again.","woo-gutenberg-products-block");case _(e):return Object(s.__)("Unable to process this payment, please try again or use alternative method.","woo-gutenberg-products-block");case O.CARD_ERROR:return j(t);case O.VALIDATION_ERROR:return""}return null},S=e=>{let{country:t,state:r,city:n,postcode:o}=e;return{country:t,state:r,city:n,postcode:o.replace(" ","").toUpperCase()}},P=()=>new Promise(e=>{try{e(function(){for(var e=arguments.length,t=new Array(e),r=0;r<e;r++)t[r]=arguments[r];y=!0;var n=Date.now();return m.then((function(e){return d(e,t,n)}))}((()=>{const e=w().publicKey;if(!e)throw new Error("There is no api key available for stripe. Make sure it is available on the wc.stripe_data.stripe.key property.");return e})()))}catch(t){e({error:t})}});var T=r(3);const A={style:{base:{iconColor:"#666EE8",color:"#31325F",fontSize:((e,t,r)=>{let n={};if("object"==typeof document&&"function"==typeof document.querySelector&&"function"==typeof window.getComputedStyle){const e=document.querySelector(".wc-block-checkout");e&&(n=window.getComputedStyle(e))}return n.fontSize||"16px"})(),lineHeight:1.375,"::placeholder":{color:"#fff"}}},classes:{focus:"focused",empty:"empty",invalid:"has-error"}},x=e=>{const[t,r]=Object(c.useState)(!1),[n,o]=Object(c.useState)({...A,...e}),[a,s]=Object(c.useState)("");return Object(c.useEffect)(()=>{const e=t?"#CFD7E0":"#fff";o(r=>{const n=void 0!==r.showIcon?{showIcon:t}:{};return{...r,style:{...r.style,base:{...r.style.base,"::placeholder":{color:e}}},...n}})},[t]),{options:n,onActive:Object(c.useCallback)(e=>{r(!e||(e=>!e))},[r]),error:a,setError:s}},k=e=>{let{inputErrorComponent:t,onChange:r}=e;const[n,o]=Object(c.useState)(!0),{options:a,onActive:i,error:l,setError:u}=x({hidePostalCode:!0});return Object(c.createElement)(c.Fragment,null,Object(c.createElement)("div",{className:"wc-block-gateway-container wc-inline-card-element"},Object(c.createElement)(T.CardElement,{id:"wc-stripe-inline-card-element",className:"wc-block-gateway-input",options:a,onBlur:()=>i(n),onFocus:()=>i(n),onChange:e=>{e.error?u(e.error.message):u(""),o(e.empty),r(e)}}),Object(c.createElement)("label",{htmlFor:"wc-stripe-inline-card-element"},Object(s.__)("Credit Card Information","woo-gutenberg-products-block"))),Object(c.createElement)(t,{errorMessage:l}))},I=e=>{let{onChange:t,inputErrorComponent:r}=e;const[n,o]=Object(c.useState)({cardNumber:!0,cardExpiry:!0,cardCvc:!0}),{options:a,onActive:i,error:l,setError:u}=x({showIcon:!1}),{options:p,onActive:d,error:m,setError:y}=x(),{options:f,onActive:b,error:g,setError:h}=x(),E=(e,r)=>a=>{a.error?e(a.error.message):e(""),o({...n,[r]:a.empty}),t(a)};return Object(c.createElement)("div",{className:"wc-block-card-elements"},Object(c.createElement)("div",{className:"wc-block-gateway-container wc-card-number-element"},Object(c.createElement)(T.CardNumberElement,{onChange:E(u,"cardNumber"),options:a,className:"wc-block-gateway-input",id:"wc-stripe-card-number-element",onFocus:()=>i(n.cardNumber),onBlur:()=>i(n.cardNumber)}),Object(c.createElement)("label",{htmlFor:"wc-stripe-card-number-element"},Object(s.__)("Card Number","woo-gutenberg-products-block")),Object(c.createElement)(r,{errorMessage:l})),Object(c.createElement)("div",{className:"wc-block-gateway-container wc-card-expiry-element"},Object(c.createElement)(T.CardExpiryElement,{onChange:E(y,"cardExpiry"),options:p,className:"wc-block-gateway-input",onFocus:()=>d(n.cardExpiry),onBlur:()=>d(n.cardExpiry),id:"wc-stripe-card-expiry-element"}),Object(c.createElement)("label",{htmlFor:"wc-stripe-card-expiry-element"},Object(s.__)("Expiry Date","woo-gutenberg-products-block")),Object(c.createElement)(r,{errorMessage:m})),Object(c.createElement)("div",{className:"wc-block-gateway-container wc-card-cvc-element"},Object(c.createElement)(T.CardCvcElement,{onChange:E(h,"cardCvc"),options:f,className:"wc-block-gateway-input",onFocus:()=>b(n.cardCvc),onBlur:()=>b(n.cardCvc),id:"wc-stripe-card-code-element"}),Object(c.createElement)("label",{htmlFor:"wc-stripe-card-code-element"},Object(s.__)("CVV/CVC","woo-gutenberg-products-block")),Object(c.createElement)(r,{errorMessage:g})))},M=()=>Object.entries(w().icons).map(e=>{let[t,{src:r,alt:n}]=e;return{id:t,src:r,alt:n}}),q=e=>{let{billing:t,eventRegistration:r,emitResponse:n,components:o}=e;const{ValidationInputError:a,PaymentMethodIcons:s}=o,[i,l]=Object(c.useState)(""),u=Object(T.useStripe)(),p=((e,t,r,n,o,a)=>{const[s,i]=Object(c.useState)(""),l=Object(c.useCallback)(e=>{var t;const r=e.error.type,n=e.error.code||"",o=null!==(t=R(r,n))&&void 0!==t?t:e.error.message;return i(o),o},[]),{onCheckoutAfterProcessingWithSuccess:u,onPaymentProcessing:p,onCheckoutAfterProcessingWithError:d}=e;return((e,t,r,n)=>{Object(c.useEffect)(()=>{const o=t(async t=>{let{processingResponse:o}=t;const a=o.paymentDetails||{},c=await(e=>{let{stripe:t,paymentDetails:r,errorContext:n,errorType:o,successType:a}=e;const c={type:a};if(!r.setup_intent&&!r.payment_intent_secret)return c;const s=!!r.setupIntent,i=r.verification_endpoint,l=s?r.setup_intent:r.payment_intent_secret;return t[s?"confirmCardSetup":"confirmCardPayment"](l).then((function(e){if(e.error)throw e.error;const t=e[s?"setupIntent":"paymentIntent"];return"requires_capture"!==t.status&&"succeeded"!==t.status||(c.redirectUrl=i),c})).catch((function(e){return c.type=o,c.message=e.message,c.retry=!0,c.messageContext=n,window.fetch(i+"&is_ajax"),c}))})({stripe:e,paymentDetails:a,errorContext:n.noticeContexts.PAYMENTS,errorType:n.responseTypes.ERROR,successType:n.responseTypes.SUCCESS});return c.type===n.responseTypes.ERROR&&c.retry&&r("0"),c});return()=>o()},[t,n.noticeContexts.PAYMENTS,n.responseTypes.ERROR,n.responseTypes.SUCCESS,r,e])})(a,u,n,o),((e,t,r,n,o,a,s,i)=>{const l=Object(T.useElements)();Object(c.useEffect)(()=>{const c=i(async()=>{try{const c=n.billingData;if(t)return{type:o.responseTypes.ERROR,message:t};if(""!==a&&"0"!==a)return{type:o.responseTypes.SUCCESS,meta:{paymentMethodData:{paymentMethod:"stripe",paymentRequestType:"cc",stripe_source:a},billingData:c}};const i={address:{line1:c.address_1,line2:c.address_2,city:c.city,state:c.state,postal_code:c.postcode,country:c.country}};c.phone&&(i.phone=c.phone),c.email&&(i.email=c.email),(c.first_name||c.last_name)&&(i.name=`${c.first_name} ${c.last_name}`);const u=await(async e=>{const t=w().inline_cc_form?T.CardElement:T.CardNumberElement;return await r.createSource(null==l?void 0:l.getElement(t),{type:"card",owner:e})})(i);if(u.error)return{type:o.responseTypes.ERROR,message:e(u)};if(!u.source||!u.source.id)throw new Error(R(O.API_ERROR));return s(u.source.id),{type:o.responseTypes.SUCCESS,meta:{paymentMethodData:{stripe_source:u.source.id,paymentMethod:"stripe",paymentRequestType:"cc"},billingData:c}}}catch(e){return{type:o.responseTypes.ERROR,message:e}}});return()=>{c()}},[i,n.billingData,r,a,s,e,t,o.noticeContexts.PAYMENTS,o.responseTypes.ERROR,o.responseTypes.SUCCESS,l])})(l,s,a,t,o,r,n,p),Object(c.useEffect)(()=>{const e=d(e=>{var t;let{processingResponse:r}=e;return null==r||null===(t=r.paymentDetails)||void 0===t||!t.errorMessage||{type:o.responseTypes.ERROR,message:r.paymentDetails.errorMessage,messageContext:o.noticeContexts.PAYMENTS}});return()=>{e()}},[d,o.noticeContexts.PAYMENTS,o.responseTypes.ERROR]),l})(r,t,i,l,n,u),d=e=>{e.error&&p(e),l("0")},m=M(),y=w().inline_cc_form?Object(c.createElement)(k,{onChange:d,inputErrorComponent:a}):Object(c.createElement)(I,{onChange:d,inputErrorComponent:a});return Object(c.createElement)(c.Fragment,null,y,s&&m.length&&Object(c.createElement)(s,{icons:m,align:"left"}))},N=e=>{const{locale:t}=w().button,{stripe:r}=e;return Object(c.createElement)(T.Elements,{stripe:r,locale:t},Object(c.createElement)(q,e))};var L,D;const H=P(),B=e=>{const[t,r]=Object(c.useState)("");return Object(c.useEffect)(()=>{Promise.resolve(H).then(e=>{let{error:t}=e;t&&r(t.message)})},[r]),Object(c.useEffect)(()=>{if(t)throw new Error(t)},[t]),Object(c.createElement)(N,a()({stripe:H},e))},U=M();var F={name:"stripe",label:Object(c.createElement)(e=>{const{PaymentMethodLabel:t}=e.components,r=w().title?w().title:Object(s.__)("Credit / Debit Card","woo-gutenberg-products-block");return Object(c.createElement)(t,{text:r})},null),content:Object(c.createElement)(B,null),edit:Object(c.createElement)(B,null),icons:U,canMakePayment:()=>H,ariaLabel:Object(s.__)("Stripe Credit Card payment method","woo-gutenberg-products-block"),supports:{showSavedCards:w().showSavedCards,showSaveOption:w().showSaveOption,features:null!==(L=null===(D=w())||void 0===D?void 0:D.supports)&&void 0!==L?L:[]}};const V={shippingAddressChange:null,shippingOptionChange:null,source:null};var W=r(8),Y=r.n(W);const Z=e=>{let{shippingData:t,billing:r,eventRegistration:n,onSubmit:o,setExpressPaymentError:a,emitResponse:i,onClick:l,onClose:u}=e;const{paymentRequest:p,paymentRequestEventHandlers:d,clearPaymentRequestEventHandler:m,isProcessing:y,canMakePayment:O,onButtonClick:_,abortPayment:j,completePayment:R,paymentRequestType:P}=(e=>{let{billing:t,shippingData:r,setExpressPaymentError:n,onClick:o,onClose:a,onSubmit:i}=e;const l=Object(T.useStripe)(),[u,p]=Object(c.useState)(null),[d,m]=Object(c.useState)(!1),[y,E]=Object(c.useState)(!1),[v,O]=Object(c.useState)(!1),[_,j]=Object(c.useState)(""),R=Object(c.useRef)(r),{paymentRequestEventHandlers:P,clearPaymentRequestEventHandler:A,setPaymentRequestEventHandler:x}=(()=>{const[e,t]=Object(c.useState)(V);return{paymentRequestEventHandlers:e,setPaymentRequestEventHandler:Object(c.useCallback)((e,r)=>{t(t=>({...t,[e]:r}))},[t]),clearPaymentRequestEventHandler:Object(c.useCallback)(e=>{t(t=>{const{[e]:__,...r}=t;return r})},[t])}})();Object(c.useEffect)(()=>{R.current=r},[r]),Object(c.useEffect)(()=>{var e;if(!l||!t.cartTotal.value||d||y||u)return;const n=(e=>{let{stripe:t,total:r,currencyCode:n,countryCode:o,shippingRequired:a,cartTotalItems:c}=e;const s={total:C(r),currency:n,country:o||"US",requestPayerName:!0,requestPayerEmail:!0,requestPayerPhone:!0,requestShipping:a,displayItems:b(c)};return t.paymentRequest(s)})({total:t.cartTotal,currencyCode:t.currency.code.toLowerCase(),countryCode:null===(e=Object(f.getSetting)("baseLocation",{}))||void 0===e?void 0:e.country,shippingRequired:r.needsShipping,cartTotalItems:t.cartTotalItems,stripe:l});(e=>new Promise(t=>{e.canMakePayment().then(e=>{if(e){const r=e.applePay?"apple_pay":"payment_request_api";t({canPay:!0,requestType:r})}else t({canPay:!1})})}))(n).then(e=>{p(n),j(e.requestType||""),O(e.canPay)})},[t.cartTotal,t.currency.code,r.needsShipping,t.cartTotalItems,l,y,d,u]);const k=Object(c.useCallback)(()=>{E(!0),m(!1),n(""),(e=>{let{paymentRequest:t,total:r,currencyCode:n,cartTotalItems:o}=e;t.update({total:C(r),currency:n,displayItems:b(o)})})({paymentRequest:u,total:t.cartTotal,currencyCode:t.currency.code.toLowerCase(),cartTotalItems:t.cartTotalItems}),o()},[o,u,n,t.cartTotal,t.currency.code,t.cartTotalItems]),I=Object(c.useCallback)(e=>{e.complete("fail"),E(!1),m(!0)},[]),M=Object(c.useCallback)(e=>{e.complete("success"),m(!0),E(!1)},[]);return Object(c.useEffect)(()=>{const e={removeAllListeners:()=>{}};let t=e,r=e,o=e,c=e;if(u){const e=()=>{m(!1),E(!1),p(null),a()},l=e=>{const t=h(e.shippingAddress);Y()(S(t),S(R.current.shippingAddress))?e.updateWith({status:"success",shippingOptions:g(R.current.shippingRates)}):(R.current.setShippingAddress(h(e.shippingAddress)),x("shippingAddressChange",e))},d=e=>{R.current.setSelectedRates(e.shippingOption.id),x("shippingOptionChange",e)},y=e=>{w().allowPrepaidCard||!e.source.card.funding?(x("sourceEvent",e),i()):n(Object(s.__)("Sorry, we're not accepting prepaid cards at this time.","woocommerce-gateway-stripe"))};t=u.on("shippingaddresschange",l),r=u.on("shippingoptionchange",d),o=u.on("source",y),c=u.on("cancel",e)}return()=>{u&&(t.removeAllListeners(),r.removeAllListeners(),o.removeAllListeners(),c.removeAllListeners())}},[u,v,y,x,n,i,a]),{paymentRequest:u,paymentRequestEventHandlers:P,clearPaymentRequestEventHandler:A,isProcessing:y,canMakePayment:v,onButtonClick:k,abortPayment:I,completePayment:M,paymentRequestType:_}})({billing:r,shippingData:t,setExpressPaymentError:a,onClick:l,onClose:u,onSubmit:o});(e=>{let{canMakePayment:t,isProcessing:r,eventRegistration:n,paymentRequestEventHandlers:o,clearPaymentRequestEventHandler:a,billing:s,shippingData:i,emitResponse:l,paymentRequestType:u,completePayment:p,abortPayment:d}=e;const{onShippingRateSuccess:m,onShippingRateFail:y,onShippingRateSelectSuccess:f,onShippingRateSelectFail:O,onPaymentProcessing:w,onCheckoutAfterProcessingWithSuccess:_,onCheckoutAfterProcessingWithError:j}=n,{noticeContexts:R,responseTypes:S}=l,P=Object(c.useRef)(o),T=Object(c.useRef)(s),A=Object(c.useRef)(i),x=Object(c.useRef)(u);Object(c.useEffect)(()=>{P.current=o,T.current=s,A.current=i,x.current=u},[o,s,i,u]),Object(c.useEffect)(()=>{const e=e=>{const t=P.current;t.shippingAddressChange&&r&&t.shippingAddressChange.updateWith({status:e.hasInvalidAddress?"invalid_shipping_address":"fail",shippingOptions:[]}),a("shippingAddressChange")},n=()=>{const e=P.current;return e.sourceEvent&&r?{type:S.SUCCESS,meta:{billingData:E(e.sourceEvent),paymentMethodData:v(e.sourceEvent,x.current),shippingData:(t=e.sourceEvent,t.shippingAddress?{address:h(t.shippingAddress)}:null)}}:{type:S.SUCCESS};var t},o=e=>{const t=P.current;let n={type:S.SUCCESS};if(t.sourceEvent&&r){const{paymentStatus:r,paymentDetails:o}=e.processingResponse;r===S.SUCCESS&&p(t.sourceEvent),r!==S.ERROR&&r!==S.FAIL||(d(t.sourceEvent),n={type:S.ERROR,message:null==o?void 0:o.errorMessage,messageContext:R.EXPRESS_PAYMENTS,retry:!0}),a("sourceEvent")}return n};if(t&&r){const t=m(e=>{const t=P.current,n=T.current;t.shippingAddressChange&&r&&(t.shippingAddressChange.updateWith({status:"success",shippingOptions:g(e),total:C(n.cartTotal),displayItems:b(n.cartTotalItems)}),a("shippingAddressChange"))}),c=y(e),s=f(function(){let e=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];return()=>{const t=P.current,n=A.current,o=T.current;if(t.shippingOptionChange&&!n.isSelectingRate&&r){const r=e?{status:"success",total:C(o.cartTotal),displayItems:b(o.cartTotalItems)}:{status:"fail"};t.shippingOptionChange.updateWith(r),a("shippingOptionChange")}}}()),i=O(e),l=w(n),u=_(o),p=j(o);return()=>{p(),u(),l(),c(),t(),s(),i()}}},[t,r,m,y,f,O,w,_,j,S,R,p,d,a])})({canMakePayment:O,isProcessing:y,eventRegistration:n,paymentRequestEventHandlers:d,clearPaymentRequestEventHandler:m,billing:r,shippingData:t,emitResponse:i,paymentRequestType:P,completePayment:R,abortPayment:j});const{theme:A}=w().button,x={paymentRequestButton:{type:"default",theme:A,height:"48px"}};return O&&p?Object(c.createElement)(T.PaymentRequestButtonElement,{onClick:_,options:{style:x,paymentRequest:p}}):null};var z,$;const Q=P(),K=P();let X=!1,G=!1;var J={name:"payment_request",content:Object(c.createElement)(e=>{const{locale:t}=w().button,{stripe:r}=e;return Object(c.createElement)(T.Elements,{stripe:r,locale:t},Object(c.createElement)(Z,e))},{stripe:K}),edit:Object(c.createElement)(()=>Object(c.createElement)("img",{src:"data:image/svg+xml,%3Csvg width='264' height='48' viewBox='0 0 264 48' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='264' height='48' rx='3' fill='black'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M125.114 16.6407C125.682 15.93 126.067 14.9756 125.966 14C125.135 14.0415 124.121 14.549 123.533 15.2602C123.006 15.8693 122.539 16.8641 122.661 17.7983C123.594 17.8797 124.526 17.3317 125.114 16.6407Z' fill='white'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M125.955 17.982C124.601 17.9011 123.448 18.7518 122.801 18.7518C122.154 18.7518 121.163 18.0224 120.092 18.0421C118.696 18.0629 117.402 18.8524 116.694 20.1079C115.238 22.6196 116.31 26.3453 117.726 28.3909C118.414 29.4028 119.242 30.5174 120.334 30.4769C121.366 30.4365 121.77 29.8087 123.024 29.8087C124.277 29.8087 124.641 30.4769 125.733 30.4567C126.865 30.4365 127.573 29.4443 128.261 28.4313C129.049 27.2779 129.373 26.1639 129.393 26.1027C129.373 26.0825 127.209 25.2515 127.189 22.7606C127.169 20.6751 128.888 19.6834 128.969 19.6217C127.998 18.1847 126.481 18.0224 125.955 17.982Z' fill='white'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M136.131 23.1804H138.834C140.886 23.1804 142.053 22.0752 142.053 20.1592C142.053 18.2432 140.886 17.1478 138.845 17.1478H136.131V23.1804ZM139.466 15.1582C142.411 15.1582 144.461 17.1903 144.461 20.1483C144.461 23.1172 142.369 25.1596 139.392 25.1596H136.131V30.3498H133.775V15.1582H139.466Z' fill='white'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M152.198 26.224V25.3712L149.579 25.5397C148.106 25.6341 147.339 26.182 147.339 27.14C147.339 28.0664 148.138 28.6667 149.39 28.6667C150.988 28.6667 152.198 27.6449 152.198 26.224ZM145.046 27.2032C145.046 25.2551 146.529 24.1395 149.263 23.971L152.198 23.7922V22.9498C152.198 21.7181 151.388 21.0442 149.947 21.0442C148.758 21.0442 147.896 21.6548 147.717 22.5916H145.592C145.656 20.6232 147.507 19.1914 150.01 19.1914C152.703 19.1914 154.459 20.602 154.459 22.7917V30.351H152.282V28.5298H152.229C151.609 29.719 150.241 30.4666 148.758 30.4666C146.571 30.4666 145.046 29.1612 145.046 27.2032Z' fill='white'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M156.461 34.4145V32.5934C156.608 32.6141 156.965 32.6354 157.155 32.6354C158.196 32.6354 158.785 32.1932 159.142 31.0564L159.353 30.3824L155.366 19.3281H157.827L160.604 28.298H160.657L163.434 19.3281H165.832L161.698 30.9402C160.752 33.6038 159.668 34.4778 157.376 34.4778C157.197 34.4778 156.618 34.4565 156.461 34.4145Z' fill='white'/%3E%3C/svg%3E%0A",alt:""}),null),canMakePayment:e=>{var t,r,n;return function(e){let{currencyCode:t,totalPrice:r}=e;return!(r<30)&&(X?G:Q.then(e=>{var n;if(null===e)return X=!0,G;if(e.error&&e.error instanceof Error)throw e.error;return e.paymentRequest({total:{label:"Total",amount:r,pending:!0},country:null===(n=Object(f.getSetting)("baseLocation",{}))||void 0===n?void 0:n.country,currency:t}).canMakePayment().then(e=>(G=!!e,X=!0,G))}))}({currencyCode:null==e||null===(t=e.cartTotals)||void 0===t||null===(r=t.currency_code)||void 0===r?void 0:r.toLowerCase(),totalPrice:parseInt((null==e||null===(n=e.cartTotals)||void 0===n?void 0:n.total_price)||0,10)})},paymentMethodId:"stripe",supports:{features:null!==(z=null===($=w())||void 0===$?void 0:$.supports)&&void 0!==z?z:[]}};Object(n.registerPaymentMethod)(F),w().allowPaymentRequest&&Object(n.registerExpressPaymentMethod)(J)}]);