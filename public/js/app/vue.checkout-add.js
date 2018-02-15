// vue
if (document.getElementById('checkout-form') != null) {

var format = new curFormatter();
var vueCheckOut = new Vue({
    config: {
        debug: true
    },
    el: '#checkout-form',
    data: {
        checkInItems: window.checkin.checkInItems,
        selectedCheckin: [],
        selectedCheckinData: [],
        displayDiscount: 0,
        checkout: {
            totalRooms: 0, // total rooms
            harga:0,
            totalAddCharge: 0, // total additional service
            subtotal: 0, // total rooms + additional service
            discountPercent: 0,
            discount: 0,
            totalAfterDiscount: 0,
            servicePercent: 0,
            service: 0,
            taxPercent: 0,
            tax: 0,
            deposit: 0,
            refund: 0,
            total: 0,
            cash: 0,
            creditcardAmount: 0,
            paymentChange: 0,
            is_discount_room_only: 0,
            is_service_room_only: 0,
            is_tax_room_only: 0
        },
        addChargeData: [],
        loading: {
            biayaTambahan: false,
            deposit: false
        }
    },
    methods: {
        setTotalRooms: function () {
            var totalRooms = 0;
            (this.selectedCheckinData).forEach (function (value, index) {
                var price = value.price*1;
                var priceExtra = value.priceExtra*1;
                totalRooms += price + priceExtra;
            });
            this.checkout.totalRooms = format.format(totalRooms);
        },//setTotalRooms
        setHarga: function () {
            var harga = 0;
            (this.selectedCheckinData).forEach (function (value, index) {
                var price = value.price*1;
                var priceExtra = value.priceExtra*1;
                harga = price + priceExtra;
            });
            this.checkout.harga = format.format(harga);
        },//setharga
        setAddCharge: function () {
            var totalAddCharge = 0;
            (this.addChargeData).forEach (function (value, index) {
                var subtotal = format.unformat(value.subtotal);
                totalAddCharge += parseInt(subtotal); //konversi string ke integer
            });
            this.checkout.totalAddCharge = format.format(totalAddCharge);
        },//setAddCharge
        setSubtotal: function () {
             var subtotal = format.unformat(this.checkout.totalAddCharge)*1 + format.unformat(this.checkout.totalRooms)*1;
             this.checkout.subtotal = format.format(subtotal);
             this.setDiscount();
             this.setTotal();
        },//setSubtotal
        setDiscount: function () {
            var co = this.checkout;
            var discountType = co.is_discount_room_only;
            var discount = 0;

            if (discountType == 0) {
                discount = format.unformat(co.subtotal )* co.discountPercent / 100;
            } else if (discountType == 1) {
                discount = format.unformat(co.totalRooms) * co.discountPercent / 100;
            } else if (discountType == 2) {
                discount = format.unformat(co.totalAddCharge) * co.discountPercent / 100;
            }
            this.checkout.discount = discount;
            this.checkout.totalAfterDiscount = format.unformat(co.subtotal) - discount;
            this.setTotal();
        }, //setDiscount
        setServiceCharge: function () {
            var co = this.checkout;
            var chargeType = co.is_service_room_only;
            var serviceCharge = 0;

            if (chargeType == 0) {
                serviceCharge = format.unformat(co.totalAfterDiscount) * co.servicePercent / 100;
            } else if (chargeType == 1) {
                serviceCharge = format.unformat(co.totalRooms) * co.servicePercent / 100;
            } else if (chargeType == 2) {
                serviceCharge = format.unformat(co.totalAddCharge) * co.servicePercent / 100;
            }
            this.checkout.service = serviceCharge;
            this.setTotal();
        }, //setDiscount
        setTax: function () {
            var co = this.checkout;
            var taxType = co.is_tax_room_only;
            var taxCharge = 0;

            if (taxType == 0) {
                taxCharge = format.unformat(co.totalAfterDiscount) * co.taxPercent / 100;
            } else if (taxType == 1) {
                taxCharge = format.unformat(co.totalRooms) * co.taxPercent / 100;
            } else if (taxType == 2) {
                taxCharge = format.unformat(co.totalAddCharge) * co.taxPercent / 100;
            }
            this.checkout.tax = taxCharge;
            this.setTotal();
        }, //setTax
        setTotal: function () {
            var co = this.checkout;
            this.checkout.total = format.unformat(co.totalAfterDiscount)*1 + format.unformat(co.service)*1 + format.unformat(co.tax)*1;
            // gt = sisa deposit
            var change = format.unformat(co.deposit)*1 - format.unformat(this.checkout.total)
            if (change > 0) {
                var ref = change;
                this.checkout.refund = format.format(ref);
                this.checkout.total = 0;
            } else {
                this.checkout.refund = 0;
                this.checkout.total = format.unformat(this.checkout.total) - format.unformat(co.deposit)*1;
                this.checkout.total = format.format(this.checkout.total);
            }
        },
        setPayment: function () {
            var co = this.checkout;
            var totalPayment = 0;
            var total = format.unformat(co.total);
            //console.log(co.total*1, co.cash*1, co.creditcardAmount*1);
            totalPayment = format.unformat(co.cash)*1 + format.unformat(co.creditcardAmount)*1;
            this.checkout.paymentChange = totalPayment - total
        },
        saveCheckout: function () {

        },
        getDeposit: function () {
            var url = this.url.deposit;
            if (this.selectedCheckin.length !== 0) {
                this.loading.deposit = true
                vueCheckOut.$http.post(url, {
                    'selectedCheckin' : this.selectedCheckin
                }).then((response) => {
                    var depo = response.data;
                    this.checkout.deposit = format.format(depo);
                    this.loading.deposit = false
                }, (response) => {

                });
            } else {
                this.checkout.deposit = 0;
            }
        }
    },
    watch: {
        selectedCheckin: function (val, oldVal) {
            var selectedCheckinData = [];
            var checkinItems = this.checkInItems;
            (val).forEach (function (value, index) {
                selectedCheckinData.push(checkinItems[value]);
            });
            this.selectedCheckinData = selectedCheckinData;

            this.getDeposit();
            this.setTotalRooms();
            this.setHarga();
        }, //selectedCheckin
        addChargeData: function (val, oldVal) {
            this.setAddCharge();
            this.setSubtotal();
        }, //addChargeData
        'checkout.discountPercent':  function (val, oldVal) {
            this.setDiscount();
        }, //discountPercent
        'checkout.servicePercent':  function (val, oldVal) {
            this.setServiceCharge();
        }, //setServiceCharge,
        'checkout.taxPercent':  function (val, oldVal) {
            this.setTax();
        }, //taxPercent
        'checkout.is_discount_room_only':  function (val, oldVal) {
            this.setDiscount();
        }, //is_discount_room_only
        'checkout.is_service_room_only':  function (val, oldVal) {
            this.setServiceCharge();
        }, //is_service_room_only
        'checkout.is_tax_room_only':  function (val, oldVal) {
            this.setTax();
        }, //is_tax_room_only
        'checkout.deposit':  function (val, oldVal) {
            this.setTotal();
        }, //is_tax_room_only
        /*'checkout.refund':  function (val, oldVal) {
            this.setTotal();
        }, *///is_tax_room_only
        'checkout.cash':  function (val, oldVal) {
            this.setPayment();
        }, //is_tax_room_only
        'checkout.creditcardAmount':  function (val, oldVal) {
            this.setPayment();
        }, //is_tax_room_only
        displayDiscount: function (val, oldVal) {
            if (val == 0) {
                $('#dicount-ppn').hide();
            }
            else {
                $('#dicount-ppn').show();
            }
        }
    },
    computed: {
        displayRoomTable: function () {
            if ((this.selectedCheckin).length == 0) {
                return false;
            } else {
                return true;
            }
        }, // displayRoomTable
        displayAddChargeDataTable: function () {
            if ((this.addChargeData).length == 0) {
                return false;
            } else {
                return true;
            }
        }, //displayAddChargeDataTable
        isSaveable: function () {
            if (this.paymentChange >= 0) {
                return true;
            } else {
                return false;
            }
        }
    }
});

    $('#dicount-ppn').hide();

    // ajax
    vueCheckOut.$watch('selectedCheckin', function (val) {
        if (val.length !== 0) {
            this.loading.biayaTambahan = true
            vueCheckOut.$http.post(vueCheckOut.$get('getResvDetailURL'), {
                'selectedCheckin' : vueCheckOut.$get('selectedCheckin')
            }).then((response) => {
                vueCheckOut.$set('addChargeData', response.json());
                this.loading.biayaTambahan = false
            }, (response) => {

            });
        } else {
            vueCheckOut.$set('addChargeData', []);
        }
    });

    document.getElementById('checkout-form').addEventListener('submit',function(e){
        var cash = parseFloat(document.getElementsByName('cash')[0].value);
        var cc = parseFloat(document.getElementsByName('creditcard_amount')[0].value);
        var total = parseFloat(document.getElementsByName('total')[0].value);
        total = format.unformat(total);

        if(cash+cc != total)
        {
            alert("Jumlah pembayaran tidak sesuai !");
            e.preventDefault();
            return false;
        }

    });

}
