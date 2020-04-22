<template>
    <CRow>
        <CCol sm="4">
            <CCard bodyWrapper borderColor="primary">
                <input type="hidden" name="id" v-model="id">
                <CInput :label="$t('id')" v-model="id" disabled />
                <CInput :label="$t('type')" v-model="type" />

                <CButton color="primary" variant="outline" square size="sm" v-on:click="save()">
                    <span  v-show="id !=$t('New Record')" >{{$t('Edit')}}</span>
                    <span  v-show="id ==$t('New Record')" >{{$t('Add')}}</span>
                </CButton>
                <CButton color="primary" variant="outline" square size="sm" v-on:click="newRecord()">
                    {{$t('New Record')}}
                </CButton>
            </CCard>
        </CCol>
        <CCol sm="8">
            <CCard bodyWrapper>
                <DataTable link="/api/product_type" :fields="fields" ref="table">
                        <template #index="{index}">
                            <td class="py-2">
                                {{index}}
                            </td>
                        </template>
                        <template #show_details="{item, index}">
                            <td class="py-2">
                                <CButton color="primary" variant="outline" square size="sm" v-on:click="edit(item.id)">
                                    <CIcon name="cil-pencil"/>
                                </CButton>
                                <CButton v-show="item.status == 2" color="primary" variant="outline" square size="sm" v-on:click="remove(item.id)">
                                    {{$t('Delete')}}
                                </CButton>
                                <CButton v-show="item.status == 1" color="primary" variant="outline" square size="sm" v-on:click="recover(item.id)">
                                    {{$t('Recover')}}
                                </CButton>
                            </td>
                        </template>
                        <template #over-table>
                            <div class="text-right">
                                <CButton color="danger" variant="outline" square size="sm" @click="trashModal = true">
                                    <CIcon name="cil-trash"/>   
                                </CButton>
                            </div>
                        </template>
                </DataTable>
            </CCard>
        </CCol>
        <CModal
            title="Trash"
            color="warning"
            size="lg" 
            :show.sync="trashModal"
            >
            <template #footer-wrapper  >
                &nbsp;
            </template>
            <template>
                <DataTable link="/api/product_type/delete" :fields="fields" ref="tableTrash">
                    <template #index="{index}">
                        <td class="py-2">
                            {{index}}
                        </td>
                    </template>
                    <template #show_details="{item, index}">
                        <td class="py-2">
                            <CButton v-show="item.status == 2" color="primary" variant="outline" square size="sm" v-on:click="remove(item.id)">
                                {{$t('Delete')}}
                            </CButton>
                            <CButton v-show="item.status == 1" color="primary" variant="outline" square size="sm" v-on:click="recover(item.id)">
                                {{$t('Recover')}}
                            </CButton>
                        </td>
                    </template>
                </DataTable>
            </template>
        </CModal>
    </CRow>
</template>

<script>
    import DataTable from '../General/DataTable';
    import Vue from 'vue';
    import {CRow, CButton,CCol, CBadge, CInput, CIcon, CCard, CModal,CElementCover, CSpinner} from '@coreui/vue';
    export default {
        name: 'productType',
        components: {
            DataTable,
            CRow, CButton,CCol, CBadge, CInput, CIcon, CCard, CModal,CElementCover, CSpinner
        },
        data () {
            return {
                trashModal: false,
                fields: [
                    { key: 'id', _style:'width:10%', label: Vue.i18n.translate('id')},
                    { key: 'type',  label: Vue.i18n.translate('type')},
                    { 
                        key: 'show_details', 
                        label: '', 
                        _style:'width:20%',
                        sorter: false, 
                        filter: false
                    }
                ],
                id: null,
                type: ''
            }  
        },
        computed: {
            isLoading() {
            return this.$store.state.isLoading;
            } 
        },
        created() {
        },
        mounted() {
            this.newRecord();
        },
        methods: {
            edit(id) {
                this.$chttp.get('/api/product_type/'+id).then(item=> {
                    this.id = item.data.id;
                    this.type = item.data.type;
                });
            },
            remove(id) {
                this.$chttp.delete('/api/product_type/'+id).then(item=> {
                    this.$refs.table.getItem();
                    this.$refs.tableTrash.getItem();
                });
            },
            recover(id) {
                this.$chttp.put('/api/product_type/'+id, {}).then(item=> {
                    this.$refs.table.getItem();
                    this.$refs.tableTrash.getItem();
                });
            },
            newRecord() {
                this.id = Vue.i18n.translate('New Record');
                this.type = '';
            },
            save() {
                var data = {
                    id: this.id,    
                    type: this.type
                };
                if(this.id == Vue.i18n.translate('New Record')) {
                    data.id = null;
                }
                this.$chttp.post('/api/product_type', data).then(item=> {
                    this.id= item.data.id;
                    this.$refs.table.getItem();
                    this.$refs.tableTrash.getItem();
                });
            }
        }
    }
</script>
