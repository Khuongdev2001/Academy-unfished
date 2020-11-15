function onlyNumber(ids) {
    /*
     * HÃ m chá»‰ cho phÃ©p nháº¥n nÃºt number
     * NgÃ y phÃ¡t triá»ƒn 17-9-2020
     * NgÆ°á»i phÃ¡t triá»ƒn: Nguyá»…n Há»¯u KhÆ°Æ¡ng
     * 
     * for tá»«ng pháº§n tá»­ máº£ng
     * 
     * láº·p tá»«ng pháº§n tá»­ ghÃ©p thÃ nh dáº¡ng #id1,#id2
     * 
     * xÃ³a bá» dáº¥u , Ä‘á»©ng cuá»‘i
     */
    let length_id = ids.length,
        id = '';
    for (let i = 0; i < length_id; i++) {
        id += '#' + ids[i] + ',';
    }
    id = id.substring(0, id.length - 1);
    $(id).keydown(e => {
        // console.log(e.originalEvent.keyCode);
        let keyCode = e.originalEvent.keyCode,
            // 37:left 38:up 39:right 40:down 46,231:delete,8:spacebace
            accept = [37, 38, 39, 40, 46, 8];
        if (!/[0-9]/.test(e.originalEvent.key) && accept.indexOf(keyCode) === -1) {
            // cháº·n sá»± kiá»‡n
            e.preventDefault();
        }
    })
}