<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="upload-btn-wrapper">
                    <button class="btn btn-success">Upload pdf</button>
                    <input type="file" v-on:change="uploadPdfHandler">
                </div>
            </div>
        </div>
        <div class="row thumbnails">
            <div class="col-3" v-for="pdf in data.pdfs">
                <a v-on:click.prevent="openPdf(pdf.id)" href="#">
                    <img src="https://www.online-tech-tips.com/wp-content/uploads/2009/09/smallpdf.jpg" alt="">
                </a>
            </div>
        </div>

        <div class="row">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a v-on:click.prevent="prevPage()" class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a v-on:click.prevent="nextPage()" class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>

        <!-- use the modal component, pass in the prop -->
        <modal v-if="show.pdf" @close="show.pdf = false">
            <!--
              you can use custom content here to overwrite
              default content
            -->
            <h3 slot="header">custom header</h3>
        </modal>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                show: {
                  pdf: false
                },
                data: {
                    perPage: 20,
                    currentPage: 1,
                    totalPages: null,
                    pdfs: {
                        1: {
                            id: 1
                        }
                    },
                    urls: {
                        upload: '',
                        getAll: '',
                    }
                },
            }
        },
        methods: {
            uploadPdfHandler(e) {

                // TODO check if it's pdf format

                let file = e.target.files || e.dataTransfer.files;

                if (!file.length) {
                    //
                }

                this._uploadPdf(file.item(0));

            },
            _uploadPdf(pdf) {

                let data = new FormData(),
                    config = {
                        headers: {'content-type': 'multipart/form-data'}
                    };

                data.append('file', pdf);

                axios.post(this.urls.upload, data, config)
                    .then(result => {

                        //

                    }).catch(result => {

                    //

                });

            },
            openPdf(id) {
                this.show.pdf = true;
            },
            nextPage() {
                this.data.currentPage += 1;
            },
            prevPage() {
                this.data.currentPage -= 1;
            }
        }
    }
</script>
