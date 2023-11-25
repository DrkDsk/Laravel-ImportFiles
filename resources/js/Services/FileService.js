export function downloadFile(file_export_id)  {
    axios({
        url: route('report.download', file_export_id),
        method: 'get',
        responseType: 'blob'
    }).then((response) => {
        let fileURL = window.URL.createObjectURL(new Blob([response.data]));
        let fileLink = document.createElement('a');
        fileLink.href = fileURL;
        fileLink.setAttribute('download', 'reporte.xlsx');
        document.body.appendChild(fileLink);
        fileLink.click();
    })
}

export function setDefaultImageBrand(e) {
    e.target.src = "/img/base_brand.jpg"
}

export default {
    downloadFile,
    setDefaultImageBrand
}
