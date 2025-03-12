!function(){"use strict";var e={n:function(r){var o=r&&r.__esModule?function(){return r.default}:function(){return r};return e.d(o,{a:o}),o},d:function(r,o){for(var n in o)e.o(o,n)&&!e.o(r,n)&&Object.defineProperty(r,n,{enumerable:!0,get:o[n]})},o:function(e,r){return Object.prototype.hasOwnProperty.call(e,r)}},r=window.ReactJSXRuntime,o=window.wp.blocks;function n(e,r){(null==r||r>e.length)&&(r=e.length);for(var o=0,n=Array(r);o<r;o++)n[o]=e[o];return n}var t=window.wp.i18n,l=window.wp.blockEditor,a=window.wp.components,i=window.wp.primitives,s=(0,r.jsx)(i.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg",children:(0,r.jsx)(i.Path,{d:"M4 4v1.5h16V4H4zm8 8.5h8V11h-8v1.5zM4 20h16v-1.5H4V20zm4-8c0-1.1-.9-2-2-2s-2 .9-2 2 .9 2 2 2 2-.9 2-2z"})}),d=(0,r.jsx)(i.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,r.jsx)(i.Path,{d:"M4 6v11.5h16V6H4zm1.5 1.5h6V11h-6V7.5zm0 8.5v-3.5h6V16h-6zm13 0H13v-3.5h5.5V16zM13 11V7.5h5.5V11H13z"})}),c=window.wp.data,h=function(e){var o=e.attributes,n=e.setAttributes,l=(0,c.useSelect)((function(e){return{categories:(0,e("core").getEntityRecords)("taxonomy","attachment_category",{per_page:-1})}}),[]).categories,i=o.category,s=((void 0===i?"":i).split(",").filter(Boolean),l&&l.map((function(e){return e.slug})),l?l.map((function(e){return{label:e.name,value:e.slug,files:e.count,description:e.description}})):[]);return(0,r.jsx)(r.Fragment,{children:s.length>0?(0,r.jsx)(a.ComboboxControl,{__experimentalRenderItem:function(e){return(0,r.jsxs)(r.Fragment,{children:[(0,r.jsxs)("div",{style:{marginBottom:".2rem"},children:[(0,r.jsx)("strong",{children:e.item.label}),(0,r.jsx)("br",{})]}),(0,r.jsxs)("small",{children:[e.item.files,e.item.files>1?(0,t.__)(" files in this category: ","rrze-downloads"):(0,t.__)(" file in this category: ","rrze-downloads")]}),e.item.description&&(0,r.jsxs)(r.Fragment,{children:[(0,r.jsx)("br",{}),(0,r.jsx)("small",{children:(0,r.jsx)("em",{children:e.item.description})})]})]})},options:s,onChange:function(e){n({category:e})},label:(0,t.__)("Filter by Category","rrze-downloads"),help:(0,t.__)("Select a category to filter the downloads by.","rrze-downloads"),value:o.category}):(0,r.jsxs)(r.Fragment,{children:[(0,r.jsx)(a.__experimentalText,{children:(0,t.__)("You currently have no Media Categories setup and in use. Follow these steps to create a custom Media Category:","rrze-downloads")}),(0,r.jsxs)("ol",{children:[(0,r.jsx)("li",{children:(0,t.__)("Navigate to Dashboard > Media Library > Categories","rrze-downloads")}),(0,r.jsx)("li",{children:(0,t.__)("Create a new Media Category with a descriptive name and a description.","rrze-downloads")}),(0,r.jsx)("li",{children:(0,t.__)("Start adding new Media items to your categories via your WordPress Media Library (Dashboard > Media Library)","rrze-downloads")}),(0,r.jsx)("li",{children:(0,t.__)("Save your current post or page and refresh the Editor to filter your download list by your newly created Media Library.","rrze-downloads")})]})]})})},_=window.wp.element,u=window.wp.serverSideRender,p=e.n(u),x=JSON.parse('{"UU":"rrze-downloads/downloads"}');(0,o.registerBlockType)(x.UU,{icon:{src:(0,r.jsx)("svg",{xmlns:"http://www.w3.org/2000/svg",height:"24px",viewBox:"0 -960 960 960",width:"24px",fill:"evenodd",children:(0,r.jsx)("path",{d:"M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"})})},__experimentalLabel:function(e,r){var o=r.context,n=e.title;if("list-view"===o&&n)return n},edit:function(e){var o,i,c=e.attributes,u=e.setAttributes,x=(0,l.useBlockProps)(),w=(o=(0,_.useState)(c.isInitialSetup),i=2,function(e){if(Array.isArray(e))return e}(o)||function(e,r){var o=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=o){var n,t,l,a,i=[],s=!0,d=!1;try{if(l=(o=o.call(e)).next,0===r){if(Object(o)!==o)return;s=!1}else for(;!(s=(n=l.call(o)).done)&&(i.push(n.value),i.length!==r);s=!0);}catch(e){d=!0,t=e}finally{try{if(!s&&null!=o.return&&(a=o.return(),Object(a)!==a))return}finally{if(d)throw t}}return i}}(o,i)||function(e,r){if(e){if("string"==typeof e)return n(e,r);var o={}.toString.call(e).slice(8,-1);return"Object"===o&&e.constructor&&(o=e.constructor.name),"Map"===o||"Set"===o?Array.from(e):"Arguments"===o||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(o)?n(e,r):void 0}}(o,i)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()),g=w[0],m=w[1],b=[{key:"liste",title:(0,t.__)("List","rrze-downloads"),icon:s,onClick:function(){u({format:"liste"})}},{key:"table",title:(0,t.__)("Table","rrze-downloads"),icon:d,onClick:function(){u({format:"table"})}}];return(0,r.jsx)("div",Object.assign({},x,{children:g?(0,r.jsx)(r.Fragment,{children:(0,r.jsxs)(a.Placeholder,{label:(0,t.__)("Downloads Block","rrze-downloads"),instructions:(0,t.__)("Configure your downloads block..","rrze-downloads"),isColumnLayout:!0,children:[(0,r.jsxs)("div",{children:[(0,r.jsx)(a.__experimentalSpacer,{paddingTop:"1rem",paddingBottom:"1rem",children:(0,r.jsx)("hr",{})}),(0,r.jsxs)(a.__experimentalGrid,{columns:6,children:[(0,r.jsxs)("div",{style:{gridColumn:"span 3"},children:[(0,r.jsx)(a.__experimentalSpacer,{paddingBottom:"1rem",children:(0,r.jsx)(a.__experimentalHeading,{level:4,children:(0,t.__)("Filter by Media Category","rrze-downloads")})}),(0,r.jsx)(a.__experimentalSpacer,{paddingRight:"2rem",children:(0,r.jsx)(h,{attributes:{category:c.category||"",num:c.num},setAttributes:u})})]}),(0,r.jsxs)("div",{style:{gridColumn:"span 3"},children:[(0,r.jsx)(a.__experimentalHeading,{level:4,children:(0,t.__)("Filter by File Type","rrze-downloads")}),(0,r.jsx)(a.__experimentalSpacer,{}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Text files","rrze-downloads"),checked:c.search_text,help:(0,t.__)("Should the Download list contain Text files?","rrze-downloads"),onChange:function(){return u({search_text:!c.search_text})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("PDF & Application files","rrze-downloads"),checked:c.search_application,help:(0,t.__)("Should the Download list contain PDF or other Application files?","rrze-downloads"),onChange:function(){return u({search_application:!c.search_application})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Images","rrze-downloads"),checked:c.search_image,help:(0,t.__)("Should the Download list contain jpg/jpeg, png or other image formats?","rrze-downloads"),onChange:function(){return u({search_image:!c.search_image})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Audio files","rrze-downloads"),help:(0,t.__)("Should the Download list contain audio files?","rrze-downloads"),checked:c.search_audio,onChange:function(){return u({search_audio:!c.search_audio})}})]})]})]}),(0,r.jsxs)("div",{children:[(0,r.jsx)(a.Button,{variant:"primary",onClick:function(){m(!1),u({isInitialSetup:!1})},children:(0,t.__)("Finish initial setup","rrze-downloads")}),(0,r.jsx)(a.__experimentalSpacer,{paddingTop:"1rem",children:(0,r.jsx)("hr",{})}),(0,r.jsx)(a.__experimentalHeading,{children:(0,t.__)("Data Preview","rrze-downloads")}),(0,r.jsx)(p(),{block:"rrze-downloads/downloads",attributes:c}),(0,r.jsx)(a.__experimentalSpacer,{})]})]})}):(0,r.jsxs)(r.Fragment,{children:[(0,r.jsxs)(l.InspectorControls,{children:[(0,r.jsxs)(a.PanelBody,{title:(0,t.__)("Filter options","rrze-downloads"),initialOpen:!1,children:[(0,r.jsx)("div",{children:(0,r.jsx)(a.__experimentalSpacer,{paddingRight:"0.2rem",children:(0,r.jsx)(h,{attributes:{category:c.category||"",num:c.num},setAttributes:u})})}),(0,r.jsxs)("div",{children:[(0,r.jsx)(a.__experimentalSpacer,{paddingTop:"1rem",children:(0,r.jsx)(a.__experimentalHeading,{level:3,children:(0,t.__)("Filter by File Type","rrze-downloads")})}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Text files","rrze-downloads"),checked:c.search_text,help:(0,t.__)("Should the Download list contain Text files?","rrze-downloads"),onChange:function(){return u({search_text:!c.search_text})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("PDF & Application files","rrze-downloads"),checked:c.search_application,help:(0,t.__)("Should the Download list contain PDF or other Application files?","rrze-downloads"),onChange:function(){return u({search_application:!c.search_application})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Images","rrze-downloads"),checked:c.search_image,help:(0,t.__)("Should the Download list contain jpg/jpeg, png or other image formats?","rrze-downloads"),onChange:function(){return u({search_image:!c.search_image})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Audio files","rrze-downloads"),help:(0,t.__)("Should the Download list contain audio files?","rrze-downloads"),checked:c.search_audio,onChange:function(){return u({search_audio:!c.search_audio})}})]})]}),(0,r.jsx)(a.PanelBody,{title:(0,t.__)("Appearance","rrze-downloads"),initialOpen:!1,children:(0,r.jsxs)(r.Fragment,{children:[(0,r.jsxs)(a.__experimentalToggleGroupControl,{__next40pxDefaultSize:!0,isBlock:!0,label:(0,t.__)("Format options","rrze-downloads"),onChange:function(e){return u({format:e})},value:c.format,help:(0,t.__)("Select a layout for the Download list.","rrze-downloads"),children:[(0,r.jsx)(a.__experimentalToggleGroupControlOption,{label:(0,t.__)("Liste","rrze-downloads"),value:"liste"}),(0,r.jsx)(a.__experimentalToggleGroupControlOption,{label:(0,t.__)("Tabelle","rrze-downloads"),value:"table"})]}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Show file size","rrze-downloads"),checked:c.showsize,help:(0,t.__)("Should the file size be displayed in kB?","rrze-downloads"),onChange:function(){return u({showsize:!c.showsize})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Show creation date","rrze-downloads"),checked:c.showcreated,help:(0,t.__)("Should the upload date be displayed?","rrze-downloads"),onChange:function(){return u({showcreated:!c.showcreated})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Show Excerpt","rrze-downloads"),checked:c.showexcerpt,help:(0,t.__)("Should the Media Caption be displayed?","rrze-downloads"),onChange:function(){return u({showexcerpt:!c.showexcerpt})}}),(0,r.jsx)(a.CheckboxControl,{label:(0,t.__)("Show content","rrze-downloads"),help:(0,t.__)("Should the Medias description be displayed?","rrze-downloads"),checked:c.showcontent,onChange:function(){return u({showcontent:!c.showcontent})}}),(0,r.jsx)(a.TextControl,{__next40pxDefaultSize:!0,__nextHasNoMarginBottom:!0,help:(0,t.__)("Modify the error message that is displayed, when no Media items are found.","rrze-downloads"),label:(0,t.__)("Custom Error Message","rrze-downloads"),onChange:function(e){u({errormsg:e})},value:c.errormsg})]})}),(0,r.jsx)(a.PanelBody,{title:(0,t.__)("Order & Sorting direction","rrze-downloads"),initialOpen:!1,children:(0,r.jsxs)(r.Fragment,{children:[(0,r.jsxs)(a.__experimentalToggleGroupControl,{__next40pxDefaultSize:!0,isBlock:!0,label:(0,t.__)("Order","rrze-downloads"),onChange:function(e){return u({orderby:e})},value:c.orderby,help:(0,t.__)("Sort your Download list by title or creation date.","rrze-downloads"),children:[(0,r.jsx)(a.__experimentalToggleGroupControlOption,{label:(0,t.__)("Title","rrze-downloads"),value:"title"}),(0,r.jsx)(a.__experimentalToggleGroupControlOption,{label:(0,t.__)("Date","rrze-downloads"),value:"date"})]}),(0,r.jsxs)(a.__experimentalToggleGroupControl,{__next40pxDefaultSize:!0,isBlock:!0,label:(0,t.__)("Sorting direction","rrze-downloads"),onChange:function(e){return u({sort:e})},value:c.sort,help:(0,t.__)("Display your Download list ascending or descending","rrze-downloads"),children:[(0,r.jsx)(a.__experimentalToggleGroupControlOption,{label:(0,t.__)("Ascending order","rrze-downloads"),value:"asc"}),(0,r.jsx)(a.__experimentalToggleGroupControlOption,{label:(0,t.__)("Descending order","rrze-downloads"),value:"desc"})]})]})})]}),(0,r.jsx)(l.BlockControls,{children:(0,r.jsx)(a.ToolbarGroup,{children:(0,r.jsx)(a.ToolbarItem,{children:function(){return(0,r.jsx)(a.ToolbarDropdownMenu,{icon:"liste"===c.format?s:d,label:(0,t.__)("Change the Layout","rrze-elements-blocks"),controls:b})}})})}),(0,r.jsx)(p(),{block:"rrze-downloads/downloads",attributes:c})]})}))},save:function(e){var o=e.attributes,n=l.useBlockProps.save();return(0,r.jsx)(r.Fragment,{children:(0,r.jsx)("div",Object.assign({},n,{children:(0,r.jsxs)("h2",{children:["Hello World! ",o.title]})}))})}})}();