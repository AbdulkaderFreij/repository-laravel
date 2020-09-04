<template>
    <div>
        <v-tabs color="#3dd475" v-model="selectedTab" @change="tabChanged">
            <v-tabs-slider></v-tabs-slider>
            <v-tab>Orders</v-tab>
            <v-tab>Products</v-tab>
        </v-tabs>
        <v-container fluid>
            <v-row>
                <v-col cols="1" sm="1">
                    <v-icon medium>
                        mdi-refresh
                    </v-icon>
                </v-col>

                <v-col cols="1" sm="0">
                    <v-icon
                        v-if="dataObject.resolved == 1"
                        color="#3dd475"
                        medium
                        @click="showResolved"
                    >
                        mdi-checkbox-marked-circle
                    </v-icon>
                    <v-icon
                        v-if="dataObject.resolved == 0"
                        medium
                        @click="showResolved"
                    >
                        mdi-checkbox-marked-circle
                    </v-icon>
                </v-col>

                <v-col cols="1" sm="0">
                    <v-icon medium>
                        mdi-launch
                    </v-icon>
                </v-col>
                <v-col class="d-flex" cols="4" sm="2" v-if="dataObject.resolved == 0">
                    <v-select
                        v-model="dataObject.status"
                        flat
                        dense
                        solo
                        :items="statusOptions"
                        item-text="status"
                        item-value="issueStatus"
                        prefix="Status: "
                        @change="changeStatus"
                    >
                    </v-select>
                </v-col>
            </v-row>
        </v-container>
        <v-data-table
            :headers="headers"
            :items="issues"
            :server-items-length="totalItems"
            :loading="loading"
            :items-per-page.sync="dataObject.per_page"
            :status.sync="dataObject.status"
            :page.sync="dataObject.page"
            class="elevation-1"
            @update:page="getData"
            @update:status="getData"
            @update:items-per-page="getData"
        >
            <template v-slot:item.id="{ item }">
                <v-chip>{{ item.id }}</v-chip>
            </template>

            <template v-slot:item.status="{ item }">
                <IssueStatus
                    :id="item.id"
                    :status="item.status"
                    @save="getData()"
                />
            </template>

            <template v-slot:item.reportable="{ item }">
                <span>{{ item.reportable_id }}</span>
            </template>

            <template v-slot:item.order.status="{ item }">
                <OrderStatus :order="item.reportable" />
            </template>

            <template v-slot:item.note.note="{ item }">
                <span v-if="item.note">{{ item.note.note }}</span>
                <OrderNote
                    v-else
                    :id="item.id"
                    :note="item.note"
                    @savedNote="getData()"
                />
            </template>

            <template v-slot:item.store="{ item }">
                <span>{{ item.store.name }}</span>
            </template>

            <template v-slot:item.customer="{ item }">
                <span>{{ item.user.email }}</span>
            </template>

            <template v-slot:item.placed-on="{ item }">
                <span @click="navigateTo(item.id)">{{
                    new Date(item.created_at).toLocaleString("en-US", {
                        weekday: "long",
                        year: "numeric",
                        month: "short",
                        day: "numeric",
                        time: "short",
                        timeZone: "Asia/Beirut",
                        hour12: true,
                        hour: "2-digit",
                        minute: "2-digit",
                        second: "2-digit"
                    })
                }}</span>
            </template>

            <template v-slot:item.order.products-quantity="{ item }">
                <IssueBadge :order="item.reportable" />
            </template>
        </v-data-table>

        <div class="text-center pt-2">
            <v-pagination
                color="#3dd475"
                v-model="dataObject.page"
                :length="totalIssues"
                :total-visible="7"
            ></v-pagination>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import IssueStatus from "./IssueStatus";
import OrderStatus from "./OrderStatus";
import OrderNote from "./OrderNote";
import IssueBadge from "./IssueBadge";
import '../../../vendor/scrivo/highlight.php/styles/dark.css';

export default {
    name: "Issue",
    components: {
        IssueStatus,
        OrderStatus,
        OrderNote,
        IssueBadge
    },
    data() {
        return {
            selectStatus: "All",
            statusOptions: [
                { issueStatus: null, status: "All" },
                { issueStatus: 0, status: "Placed" },
                { issueStatus: 1, status: "Under_Process" },
                { issueStatus: "2", status: "Resolved" },
            ],
            totalIssues: 0,
            totalItems: 0,
            selectedTab: 0,
            dataObject: {
                page: 1,
                per_page: 5,
                type: "Order",
                resolved: 0,
                status: null
            },
            loading: true,
            issues: []
        };
    },

    mounted() {
        this.getData();
    },

    computed: {
        isOrdersTab() {
            return this.selectedTab === 0;
        },

        headers() {
            if (this.isOrdersTab) {
                return [
                    {
                        text: "ID",
                        sortable: false,
                        value: "id",
                        align: "center"
                    },
                    {
                        text: "Order #",
                        value: "reportable",
                        sortable: false,
                        align: "center"
                    },
                    { text: "Status", value: "status", align: "center" },
                    { text: "Customer", value: "customer", align: "center" },
                    { text: "Store", value: "store.name", align: "center" },
                    { text: "Message", value: "message", align: "center" },
                    {
                        text: "Placed On",
                        value: "placed-on",
                        dataType: "Date",
                        align: "center"
                    },
                    {
                        text: "Order Status",
                        value: "order.status",
                        align: "center"
                    },
                    { text: "Note", value: "note.note", align: "center" },
                    {
                        text: "",
                        value: "order.products-quantity",
                        align: "center"
                    }
                ];
            }

            return [
                {
                    text: "ID",
                    align: "start",
                    sortable: false,
                    value: "id"
                },
                {
                    text: "Product #",
                    value: "reportable",
                    sortable: false
                },
                { text: "Status", value: "status", align: "center" },
                { text: "Customer", value: "customer", align: "center" },
                { text: "Store", value: "store.name", align: "center" },
                { text: "Message", value: "message", align: "center" },
                {
                    text: "Placed On",
                    value: "placed-on",
                    dataType: "Date",
                    align: "center"
                },
                {
                    text: "Order Status",
                    value: "order.status",
                    align: "center"
                },
                { text: "Note", value: "order.notes", align: "center" },
                { text: "", value: "actions", align: "center" }
            ];
        }
    },
    methods: {
        showResolved() {
            if (this.dataObject.resolved == 0) {
                this.dataObject.resolved = 1;
                delete this.dataObject.status;
            } else this.dataObject.resolved = 0;
            this.getData();
        },
        changeStatus(newStatus) {
            this.dataObject.status = newStatus
            this.getData();
        },
        tabChanged(tab) {
            this.selectedTab = tab;
            if (this.isOrdersTab) {
                this.dataObject.type = "Order";
            } else {
                this.dataObject.type = "Product";
            }
            this.getData();
        },
        getData() {
            try {
                return axios
                    .get(`http://127.0.0.1:8000/api/issues/list`, {
                        params: this.dataObject
                    })
                    .then(response => {
                        this.loading = false;
                        this.issues = response.data.data;
                        this.totalIssues = response.data.last_page;
                        this.totalItems = response.data.total
                    });
            } catch (err) {
                console.log(err);
            }
        }
    }
};
</script>

