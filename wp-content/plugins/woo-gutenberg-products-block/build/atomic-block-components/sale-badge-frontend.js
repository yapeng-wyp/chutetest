(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[13],{21:function(e,t,c){"use strict";var a=c(0),n=c(4),r=c.n(n);t.a=e=>{let t,{label:c,screenReaderLabel:n,wrapperElement:l,wrapperProps:s={}}=e;const o=null!=c,u=null!=n;return!o&&u?(t=l||"span",s={...s,className:r()(s.className,"screen-reader-text")},Object(a.createElement)(t,s,n)):(t=l||a.Fragment,o&&u&&c!==n?Object(a.createElement)(t,s,Object(a.createElement)("span",{"aria-hidden":"true"},c),Object(a.createElement)("span",{className:"screen-reader-text"},n)):Object(a.createElement)(t,s,c))}},267:function(e,t){},285:function(e,t,c){"use strict";c.r(t);var a=c(0),n=(c(8),c(1)),r=c(4),l=c.n(r),s=c(21),o=c(50),u=c(110);c(267),t.default=Object(u.withProductDataContext)(e=>{let{className:t,align:c}=e;const{parentClassName:r}=Object(o.useInnerBlockLayoutContext)(),{product:u}=Object(o.useProductDataContext)();if(!u.id||!u.on_sale)return null;const b="string"==typeof c?"wc-block-components-product-sale-badge--align-"+c:"";return Object(a.createElement)("div",{className:l()("wc-block-components-product-sale-badge",t,b,{[r+"__product-onsale"]:r})},Object(a.createElement)(s.a,{label:Object(n.__)("Sale","woo-gutenberg-products-block"),screenReaderLabel:Object(n.__)("Product on sale","woo-gutenberg-products-block")}))})}}]);