define("underscore jquery ko mage/storage Dholi_Core/js/model/url-builder Magento_Vault/js/view/payment/method-renderer/vault Magento_Checkout/js/model/quote Dholi_Payment/js/checkout".split(" "),function(d,e,b,f,g,c,h,a){return c.extend({placeOrderTotalOrderAmount:b.pureComputed(function(){return a.placeOrderTotalOrderAmount()}),installments:b.observableArray(),initialize:function(){this._super()},getMaskedCard:function(){return this.details.maskedCC},getExpirationDate:function(){return this.details.expirationDate},
getCardType:function(){return this.details.type},getParentCode:function(){return this.parentCode},getToken:function(){return this.publicHash},getIcons:function(k){return this.details.icon},getTotalOrderAmountForInstallments:function(){return a.getTotalOrderAmountForInstallments()},getTotalOrderAmount:function(){return a.getTotalOrderAmount()},getShippingAmount:function(){return a.getShippingAmount()},getPaymentUrl:function(){return a.getPaymentUrl()}})});
