(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[15],{321:function(o,c){},369:function(o,c,t){"use strict";t.r(c);var e=t(0),n=t(1),s=(t(8),t(4)),r=t.n(s),a=t(50),i=t(110);t(321);c.default=Object(i.withProductDataContext)(o=>{let{className:c}=o;const{parentClassName:t}=Object(a.useInnerBlockLayoutContext)(),{product:s}=Object(a.useProductDataContext)();if(!s.id||!s.is_purchasable)return null;const i=!!s.is_in_stock,k=s.low_stock_remaining,b=s.is_on_backorder;return Object(e.createElement)("div",{className:r()(c,"wc-block-components-product-stock-indicator",{[t+"__stock-indicator"]:t,"wc-block-components-product-stock-indicator--in-stock":i,"wc-block-components-product-stock-indicator--out-of-stock":!i,"wc-block-components-product-stock-indicator--low-stock":!!k,"wc-block-components-product-stock-indicator--available-on-backorder":!!b})},k?(o=>Object(n.sprintf)(
/* translators: %d stock amount (number of items in stock for product) */
Object(n.__)("%d left in stock","woo-gutenberg-products-block"),o))(k):((o,c)=>c?Object(n.__)("Available on backorder","woo-gutenberg-products-block"):o?Object(n.__)("In Stock","woo-gutenberg-products-block"):Object(n.__)("Out of Stock","woo-gutenberg-products-block"))(i,b))})}}]);