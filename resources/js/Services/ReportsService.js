export function exportReport(medium_id, data)  {
    axios({
        url: route('report.export', medium_id),
        method: 'post',
        data: data
    }).then((response) => {
        let dataResponse = response.data
        if (dataResponse.status === 200) {
            window.location.href = route('dashboard.fileExport.show', dataResponse.data.file_id)
        }
    })
}

export default {
    exportReport
}
