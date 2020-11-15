function ajax(method, url, box, type = "json") {
    let ajax = new XMLHttpRequest;
    ajax.responseType = type;
    ajax.open(method, url, true);
    ajax.send(box.data);
}
// show tiÃªn tá»‡ khi nháº­p input t 
function focusActive(ids) {
    /**
     * Truyền vào mảng danh sách 
     * 
     * láº·p tá»«ng pháº§n tá»­ ghÃ©p thÃ nh dáº¡ng #id1,#id2
     * 
     * xÃ³a bá» dáº¥u , Ä‘á»©ng cuá»‘i
     * 
     */
    let lengthId = ids.length,
        id = '';
    for (let i = 0; i < lengthId; i++) {
        id += '#' + ids[i] + ',';
    }
    id = id.substring(0, id.length - 1);
    /* auto load */
    $(id).each(function() {
        if ($(this).val() != '') {
            let label = $(this).parents('.form-group').find('label');
            label.addClass('active');
        }
    })

    /* focus */
    $(id).focus(function() {
        $(this).addClass('active');
        let label = $(this).parents('.form-group').find('label');
        label.addClass('active');
    })

    /* blur */
    $(id).blur(function() {
        if ($(this).val() == '') {
            $(this).removeClass('active');
            let label = $(this).parents('.form-group').find('label');
            label.removeClass('active');
        }
    })
}

// url/public 
function urlAsset(file) {
    protocol = window.location.protocol;
    host = window.location.host;
    project = 'bambooHouse';
    dir = protocol + '//' + host + '/' + project + '/public/' + file;
    return dir;
}
// url
function urlDomain(url) {
    protocol = window.location.protocol;
    host = window.location.host;
    project = 'bambooHouse';
    dir = protocol + '//' + host + '/' + project + '/' + url;
    return dir;
}

// check all
$(document).ready(function() {
    $('#checkall').click(function() {
        let checked = $(this).prop('checked');
        $('input[type="checkbox"]').each(function() {
            $(this).prop('checked', checked);
            $(this).parents('tbody tr').removeClass('active');
            if (checked) {
                $(this).parents('tbody tr').addClass('active');
            }
        });
    });
    // auto complete all input
    let input = document.querySelectorAll('input');
    for (let i = 0; i < input.length; i++) {
        input[i].setAttribute('autocomplete', 'off');
    }
    // set sorting table
    sorts = document.querySelectorAll("table th.sort");
    // convert
    convert = { asc: "sorting_asc", desc: "sorting_desc" };
    for (let i = 0; i < sorts.length; i++) {
        let hidden = sorts[i].children[0].value;
        sorts[i].classList.add(convert[hidden]);
    }
})

// upload file drop
// hÃ m nháº­p danh sÃ¡ch file láº·p vÃ  show preview
// loopFile lÃ  hÃ m láº·p tá»«ng file Ä‘á»ƒ thá»±c hiá»‡n preview vÃ  loáº¡i bá» 1 sá»‘ file
function loopFile(i, files, max, type = "image") {
    let boxPreview = document.querySelectorAll(".box-preview")[i],
        // type accept
        typeAccpet = { image: ["image/jpeg", "image/png"], video: ["video/mp4"] };
    // reset boxpreview
    boxPreview.innerHTML = "",
        col = " col-md-" + 3;
    // set col
    if (max <= 4) {
        col = " col-md-" + 12 / max;
    }
    for (let i = 0; i < files.length; i++) {
        // khai báo cho phép upload bao nhiu file thui
        if (i === max) {
            let remain = files.length - i;
            Dashmix.helpers('notify', { type: 'danger', icon: 'fa fa-times mr-1', message: 'Đã bỏ qua' + remain + ' file' });
            break;
        };
        if (typeAccpet[type].indexOf(files[i].type) < 0)
            continue;
        // kiểm tra xem có đồng bộ với định dạng được chọn không  
        let url = URL.createObjectURL(files[i]),
            control = document.createElement("img"),
            a = document.createElement("a");
        a.setAttribute("class", "d-inline-block" + col);
        control.setAttribute("class", "img-fluid animated fadeIn active");
        control.setAttribute("src", url);
        // trường hợp là video
        if (type == "video") {
            a = document.createElement("a");
            a.setAttribute("class", "d-inline-block" + col);
            control = document.createElement("video");
            control.setAttribute("class", "w-100");
            control.setAttribute("src", url);
            control.controls = true;
        }
        a.appendChild(control);
        // thÃªm cÃ¡c pháº§n tá»­ img trong khá»‘i cha #drop_file
        // animate active and setimeoute
        setTimeout(() => {
            boxPreview.appendChild(a);
        }, 100)
    }
}

function dropUploadFiles(max, type) {
    // khai báo khung drop
    let boxDrops = document.getElementsByClassName("drop-file"),
        // khai báo nút upload ảnh để trigger 
        btnUploads = document.getElementsByClassName("btn-upload"),
        // khai báo nút input file
        files = document.getElementsByClassName("files");
    // for để áp dụng nhiu phần từ vào các sự kiện
    for (let i = 0; i < boxDrops.length; i++) {
        // kéo vào và buôn ra 
        boxDrops[i].ondrop = (e) => {
                let files = e.dataTransfer.files,
                    inputFile = boxDrops[i].parentElement.children[1].children[0];
                inputFile.files = files;
                // set preview
                // có thêm i vì boxpreview bên hàm loop file chỉ có i này mới xác định được
                loopFile(i, files, max[i], type[i]);
                boxDrops[i].classList.remove("active");
                e.preventDefault();

            }
            // khi bắt đầu kéo vào khung
        boxDrops[i].ondragover = (e) => {
            boxDrops[i].classList.add("active");
            e.preventDefault();
        };
        // khi kÃ©o vÃ o vÃ  kÃ©o ra thÃ¬ báº¯t Ä‘áº§u sá»± kiá»‡n
        boxDrops[i].ondragleave = (e) => {
            boxDrops[i].classList.remove("active");
            e.preventDefault();
        };
    };
    // click trigger upload
    for (let i = 0; i < btnUploads.length; i++) {
        btnUploads[i].onclick = (e) => {
            btnUploads[i].parentElement.children[0].click();
            e.preventDefault();
        }
    }
    // change btn upload
    for (let i = 0; i < files.length; i++) {
        files[i].onchange = () => {
            loopFile(i, files[i].files, max[i], type[i]);
        }
    }
}

function numberDely(e) {
    ids = e.id;
    numStops = e.data;
    delay = e.delay || 1000;
    for (let i = 0; i < ids.length; i++) {
        let step = 0,
            delayNumber = setInterval(() => {
                step += e.step;
                document.getElementById(ids[i]).textContent = step;
                if (step >= numStops[i]) {
                    clearInterval(delayNumber);
                    document.getElementById(ids[i]).textContent = numStops[i];
                }
            }, delay);
    }
}