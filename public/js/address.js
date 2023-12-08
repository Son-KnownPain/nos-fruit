fetch('https://provinces.open-api.vn/api/?depth=3')
.then(res => res.json())
.then(data => {
    const provincesOption = document.getElementById('province');
    const districtsOption = document.getElementById('district');
    const wardsOption = document.getElementById('ward');

    // Tạo các hàm render các option
    // 1. Render tỉnh
    const renderProvinces = () => {
        const provinces = data.map(item => {
            return `<option value="${item.name}" data-code="${item.code}">${item.name}</option>`;
        })


        provincesOption.innerHTML = provinces.join('');
    }
    // 2. Render huyện
    const renderDistricts = (listDistrict) => {
        const districts = listDistrict.map(item => {
            return `<option value="${item.name}" data-code="${item.code}">${item.name}</option>`;
        })

        districtsOption.innerHTML = districts.join('');
    }
    // 3. Render ấp, phường
    const renderWards = (listWards) => {
        const wards = listWards.map(item => {
            return `<option value="${item.name}">${item.name}</option>`;
        })

        wardsOption.innerHTML = wards.join('');
    }
    

    let listDistrict = data.find(item => item.code == 1).districts;
    let listWards = data.find(item => item.code == 1).districts.find(item => item.code == 1).wards;
    // Bắt sự kiện chọn tỉnh

    provincesOption.onchange = e => {
        const provinceCode = e.target.options[e.target.selectedIndex].dataset.code;
        listDistrict = data.find(item => item.code == provinceCode).districts;

        renderDistricts(listDistrict);
        renderWards(listDistrict[0].wards);
    }
    // Bắt sự kiện chọn huyện

    districtsOption.onchange = e => {
        const districtCode = e.target.options[e.target.selectedIndex].dataset.code;
        listWards = listDistrict.find(item => item.code == districtCode).wards;

        renderWards(listWards);
    }

    // Render ra mặc định
    renderProvinces();
    renderDistricts(listDistrict);
    renderWards(listWards);

});