<script src="https://yastatic.net/pcode/adfox/header-bidding.js"></script>
<script>
    var adfoxBiddersMap = {
        'criteo': '771005'
    };
    var adUnits = [
        {
            code: 'adfox_153122878538414906',
            bids: [
                {
                    bidder: 'criteo',
                    params: {
                        zoneid: 1273129
                    }
                }
            ]

        },
        {
            code: 'adfox_15312285287521088',
            bids: [
                {
                    bidder: 'criteo',
                    params: {
                        zoneid: 1273128
                    }
                }
            ]

        }
    ];
    var userTimeout = 1000;
    window.Ya.headerBidding.setSettings({
        biddersMap: adfoxBiddersMap,
        adUnits: adUnits,
        timeout: userTimeout
    });
</script>
<script>window.yaContextCb = window.yaContextCb || []</script>
<script src="https://yandex.ru/ads/system/context.js"; async></script>