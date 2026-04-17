<script setup>
import { computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    stats: Object,
    recent_properties: Array,
    status_breakdown: Array,
    type_breakdown: Array,
    category_breakdown: Array,
    pipeline: Array,
    monthly_trends: Object,
    recent_activities: Array,
});

const { ApexChart } = VueApexCharts;

// Enhanced charts with new theme
const monthlyOptions = computed(() => ({
    chart: {
        type: 'area',
        height: 350,
        toolbar: { show: false },
        zoom: { enabled: false },
        fontFamily: 'Inter, sans-serif',
        background: 'transparent',
    },
    colors: ['#3b82f6', '#eab308'],
    fill: {
        type: 'gradient',
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.1,
            colorStops: [
                { offset: 0, color: '#3b82f6', opacity: 0.4 },
                { offset: 100, color: '#eab308', opacity: 0.1 },
            ],
        },
    },
    stroke: { curve: 'smooth', width: 3 },
    dataLabels: { enabled: false },
    grid: {
        borderColor: 'rgba(226, 232, 240, 0.5)',
        strokeDashArray: 3,
        yaxis: { lines: { show: true } },
    },
    xaxis: {
        categories: props.monthly_trends?.months || [],
        labels: { 
            style: { colors: '#64748b', fontSize: '13px' },
            rotate: -45,
        },
        axisBorder: { color: 'rgba(226, 232, 240, 0.5)' },
        axisTicks: { color: 'rgba(226, 232, 240, 0.5)' },
    },
    yaxis: {
        labels: { style: { colors: '#64748b', fontSize: '13px' } },
    },
    legend: { position: 'top', horizontalAlign: 'left', fontSize: '14px' },
    tooltip: { 
        theme: 'dark', 
        shared: true,
        intersect: false,
        custom: function({ series, dataPointIndex, w }) {
            return `
                <div class="rounded-lg bg-neutral-900 p-4 border border-neutral-800 text-white shadow-2xl">
                    <div class="text-sm font-bold text-white">${w.globals.labels[dataPointIndex]}</div>
                    <div class="mt-2 space-y-1">
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-blue-500"></div>
                            <span>Ventes: <span class="font-bold">${series[0][dataPointIndex]}</span></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="h-3 w-3 rounded-full bg-amber-500"></div>
                            <span>Locations: <span class="font-bold">${series[1][dataPointIndex]}</span></span>
                        </div>
                    </div>
                </div>
            `;
        }
    },
}));

const monthlySeries = computed(() => [
    { name: 'Ventes', data: props.monthly_trends?.sales || [] },
    { name: 'Locations', data: props.monthly_trends?.rents || [] },
]);

const donutOptions = computed(() => ({
    chart: { type: 'donut', height: 320 },
    labels: props.category_breakdown?.map(c => c.label) || [],
    colors: ['#3b82f6', '#eab308', '#f59e0b', '#10b981', '#8b5cf6', '#ef4444'],
    legend: { 
        position: 'bottom', 
        fontSize: '13px', 
        labels: { colors: '#64748b' },
        markers: { width: 12, height: 12, radius: 6 }
    },
    dataLabels: { enabled: false },
    plotOptions: {
        pie: {
            donut: { 
                size: '70%',
                labels: { 
                    show: true, 
                    name: { show: false },
                    value: { 
                        show: true, 
                        fontSize: '24px', 
                        fontWeight: '800', 
                        formatter: val => `${val.toLocaleString()}`
                    },
                    total: { 
                        show: true, 
                        label: 'Total', 
                        fontSize: '16px',
                        formatter: () => props.stats?.total?.toLocaleString() || 0
                    }
                }
            }
        }
    },
    tooltip: { 
        theme: 'dark',
        y: { formatter: val => `${val.toLocaleString()} biens` }
    },
    responsive: [{ breakpoint: 480, options: { chart: { height: 280 } } }],
}));

const donutSeries = computed(() => props.category_breakdown?.map(c => c.value) || []);

const pipelineOptions = computed(() => ({
    chart: { type: 'bar', height: 320, toolbar: { show: false } },
    plotOptions: { 
        bar: { 
            borderRadius: 12, 
            columnWidth: '60%',
            dataLabels: { position: 'top' }
        } 
    },
    colors: ['#3b82f6'],
    dataLabels: { 
        enabled: true,
        style: { fontSize: '12px', fontWeight: 700, colors: ['#fff'] },
        offsetY: -20,
        background: { borderRadius: 6, padding: 4 }
    },
    grid: { borderColor: 'rgba(226, 232, 240, 0.5)' },
    xaxis: {
        categories: props.pipeline?.map(p => p.label) || [],
        labels: { style: { colors: '#64748b', fontSize: '13px' } },
    },
    yaxis: { 
        labels: { style: { colors: '#64748b', fontSize: '13px' } },
        title: { text: 'Nombre de dossiers', style: { color: '#64748b' } }
    },
    tooltip: { 
        theme: 'dark',
        y: { formatter: val => `${val} dossier${val > 1 ? 's' : ''}` }
    },
}));

const pipelineSeries = computed(() => [{ name: 'Pipeline', data: props.pipeline?.map(p => p.value) || [] }]);

// Enhanced Metrics with Sparklines
const metricCards = computed(() => [
    { 
        label: 'Biens Total', 
        value: props.stats?.total ?? 0, 
        hint: 'Portefeuille complet', 
        color: 'primary',
        change: '+18%',
        trend: 'up',
        sparkline: [45, 52, 48, 55, 62, 58, 65]
    },
    { 
        label: 'Nouveaux Leads', 
        value: props.stats?.contacts ?? 0, 
        hint: '24h glissantes', 
        color: 'emerald',
        change: '+24%',
        trend: 'up',
        sparkline: [12, 15, 18, 22, 28, 25, 32]
    },
    { 
        label: 'Visites Planifiées', 
        value: props.stats?.inquiries ?? 0, 
        hint: 'À confirmer', 
        color: 'gold',
        change: '+12%',
        trend: 'up',
        sparkline: [8, 10, 12, 11, 14, 16, 18]
    },
    { 
        label: 'Loyers En Retard', 
        value: props.stats?.pending_rent_payments ?? 0, 
        hint: 'Échéances J+30', 
        color: 'rose',
        change: '-3%',
        trend: 'down',
        sparkline: [22, 20, 18, 21, 19, 17, 16]
    },
    { 
        label: 'Maintenance', 
        value: props.stats?.open_maintenance ?? 0, 
        hint: 'Tickets ouverts', 
        color: 'amber',
        change: '+8%',
        trend: 'up',
        sparkline: [5, 6, 4, 7, 8, 9, 10]
    },
    { 
        label: 'Taux Occupation', 
        value: `${props.stats?.occupancy_rate ?? 0}%`, 
        hint: 'Actuel', 
        color: 'emerald',
        change: '+2.4pts',
        trend: 'up',
        sparkline: [78, 80, 82, 79, 83, 84, 86]
    },
]);

const formatCurrency = (amount) => new Intl.NumberFormat('fr-FR', { 
    style: 'currency', 
    currency: 'XOF', 
    maximumFractionDigits: 0 
}).format(amount ?? 0);

onMounted(() => {
    // Simulate sparkline animations
    metricCards.value.forEach((card, index) => {
        const sparkData = card.sparkline;
        let counter = 0;
        const interval = setInterval(() => {
            sparkData[counter] += Math.floor(Math.random() * 3) - 1;
            counter = (counter + 1) % sparkData.length;
        }, 2000 + index * 500);
    });
});
</script>

<template>
    <Head title="Dashboard Prestige - Immo Sahel" />

    <AuthenticatedLayout>
        <template #header>
            <div class="px-6 py-8 lg:px-8">
                <!-- Welcome & Quick Stats -->
                <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-4xl font-display font-black text-neutral-900 tracking-tight drop-shadow-sm">
                            Bonjour,
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-gold-600"> Dashboard</span>
                        </h1>
                        <p class="mt-2 text-xl text-neutral-600 leading-relaxed">
                            Centre de contrôle immobilier - {{ new Date().toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3 lg:justify-end">
                        <Link
                            :href="route('admin.properties.create')"
                            class="inline-flex items-center gap-3 rounded-3xl bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-4 text-lg font-bold text-white shadow-2xl hover:shadow-3xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-300"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nouveau Bien
                        </Link>
                    </div>
                </div>

                <!-- KPI Grid with Sparklines -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                    <div
                        v-for="card in metricCards"
                        :key="card.label"
                        class="group relative rounded-3xl bg-white p-8 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-neutral-200/50 overflow-hidden"
                    >
                        <!-- Gradient Badge -->
                        <div class="absolute inset-0 h-1 bg-gradient-to-r from-primary-500 to-gold-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500" />

                        <!-- Content -->
                        <div class="relative z-10">
                            <div class="flex items-center justify-between">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[color:var(--card-color)] to-transparent shadow-2xl group-hover:shadow-white/20 transition-all">
                                    <svg class="h-7 w-7 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" :d="card.icon" />
                                    </svg>
                                </div>
                                <span
                                    :class="card.trend === 'up' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'"
                                    class="flex h-8 w-20 items-center justify-center rounded-2xl text-xs font-bold uppercase shadow-lg"
                                >
                                    {{ card.change }}
                                </span>
                            </div>

                            <div class="mt-6">
                                <p class="text-3xl xl:text-4xl font-black text-neutral-900 drop-shadow-lg group-hover:text-[color:var(--card-color)] transition-colors">
                                    {{ typeof card.value === 'number' ? card.value.toLocaleString() : card.value }}
                                </p>
                                <p class="mt-1 text-sm font-semibold uppercase tracking-wide text-neutral-600 group-hover:text-neutral-700">
                                    {{ card.label }}
                                </p>
                                <p class="mt-1 text-xs text-neutral-500">{{ card.hint }}</p>
                            </div>

                            <!-- Sparkline -->
                            <div class="mt-6 flex h-10 w-full items-center overflow-hidden rounded-xl bg-neutral-100/50">
                                <svg :viewBox="`0 0 ${card.sparkline.length * 8} 24`" class="flex-shrink-0">
                                    <polyline
                                        :points="card.sparkline.map((v, i) => `${i * 8},24 ${i * 8},${24 - (v / 100 * 24)}`).join(' ')"
                                        fill="none"
                                        :stroke="`#${card.color === 'primary' ? '3b82f6' : card.color === 'emerald' ? '10b981' : card.color === 'rose' ? 'ef4444' : 'eab308'}`
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="drop-shadow-lg"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Main Analytics Dashboard -->
        <div class="grid grid-cols-1 gap-8 xl:grid-cols-3 xl:grid-rows-[auto_auto_1fr]">
            <!-- Left Column - Trends -->
            <div class="xl:col-span-2 xl:row-span-3 space-y-8">
                <!-- Monthly Performance -->
                <div class="group rounded-3xl bg-white p-8 shadow-2xl border border-neutral-200/50 hover:shadow-3xl transition-all">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-display font-bold text-neutral-900">Performance Mensuelle</h3>
                            <p class="text-lg text-neutral-600 mt-2">Évolution ventes & locations</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="h-12 w-32 rounded-2xl bg-gradient-to-r from-neutral-100 to-neutral-200 text-sm font-bold text-neutral-700 shadow-sm hover:shadow-md transition-all">Mois</button>
                            <button class="h-12 w-36 rounded-2xl bg-gradient-to-r from-primary-600 to-gold-600 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all">Année</button>
                        </div>
                    </div>
                    <client-only>
                        <ApexChart v-if="monthlySeries.length" :type="monthlyOptions.chart.type" :options="monthlyOptions" :series="monthlySeries" height="400" />
                    </client-only>
                </div>

                <!-- Status Breakdown -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="group rounded-3xl bg-white p-8 shadow-xl border border-neutral-200/50 hover:shadow-2xl transition-all">
                        <h3 class="text-xl font-bold text-neutral-900 mb-8 flex items-center gap-3">
                            <svg class="h-7 w-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Statut Portefeuille
                        </h3>
                        <div class="space-y-4">
                            <div
                                v-for="item in status_breakdown"
                                :key="item.label"
                                class="group flex cursor-pointer items-center justify-between rounded-2xl p-5 bg-gradient-to-r from-neutral-50 to-white hover:shadow-md hover:from-primary-50 transition-all"
                            >
                                <div class="flex items-center gap-4">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl shadow-lg" :class="{
                                        'bg-emerald-500/10 text-emerald-700 border-2 border-emerald-200/50': item.label === 'Publié',
                                        'bg-amber-500/10 text-amber-700 border-2 border-amber-200/50': item.label === 'En attente',
                                        'bg-blue-500/10 text-blue-700 border-2 border-blue-200/50': item.label === 'Vendu',
                                        'bg-neutral-500/10 text-neutral-700 border-2 border-neutral-200/50': item.label === 'Brouillon'
                                    }">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-lg text-neutral-900 group-hover:text-neutral-950">{{ item.label }}</p>
                                        <p class="text-sm text-neutral-600">En cours de traitement</p>
                                    </div>
                                </div>
                                <div class="text-3xl font-black text-neutral-900 drop-shadow-lg">
                                    {{ item.value }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pipeline -->
                    <div class="group rounded-3xl bg-white p-8 shadow-xl border border-neutral-200/50 hover:shadow-2xl transition-all">
                        <h3 class="text-xl font-bold text-neutral-900 mb-8 flex items-center gap-3">
                            <svg class="h-7 w-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Pipeline Commercial
                        </h3>
                        <client-only>
                            <ApexChart :type="pipelineOptions.chart.type" :options="pipelineOptions" :series="pipelineSeries" height="340" />
                        </client-only>
                    </div>
                </div>
            </div>

            <!-- Right Column - Quick Actions & Recent -->
            <div class="space-y-8">
                <!-- Recent Activities Timeline -->
                <div class="rounded-3xl bg-white p-8 shadow-2xl border border-neutral-200/50">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold text-neutral-900">Activités Récentes</h3>
                        <Link href="#" class="text-sm font-semibold text-primary-700 hover:text-primary-800">Voir tout →</Link>
                    </div>
                    <div class="space-y-6">
                        <div
                            v-for="(activity, index) in recent_activities?.slice(0, 5)"
                            :key="index"
                            class="group flex cursor-pointer items-start gap-4 rounded-2xl p-6 hover:bg-primary-50 transition-all duration-200"
                        >
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-bold text-sm shadow-lg flex-shrink-0">
                                {{ activity.initials || 'AI' }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-neutral-900 group-hover:text-primary-900 line-clamp-1">
                                    {{ activity.title }}
                                </p>
                                <p class="mt-1 text-sm text-neutral-600 line-clamp-1">{{ activity.subtitle }}</p>
                                <p class="mt-2 flex items-center gap-2 text-xs text-neutral-500">
                                    <span>{{ activity.time }}</span>
                                    <div class="h-1 w-1 rounded-full bg-neutral-400" />
                                    <span>{{ activity.status }}</span>
                                </p>
                            </div>
                        </div>
                        <div v-if="!recent_activities?.length" class="text-center py-16 text-neutral-500">
                            <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4 text-lg">Aucune activité récente</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="rounded-3xl bg-gradient-to-br from-emerald-500/5 to-teal-500/5 p-8 border border-emerald-200/30 shadow-xl">
                    <h3 class="text-xl font-bold text-emerald-900 mb-8">Actions Rapides</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <Link
                            :href="route('admin.properties.create')"
                            class="group flex flex-col items-center gap-3 rounded-2xl bg-white p-6 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border hover:border-emerald-300"
                        >
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xl group-hover:shadow-emerald-500/25 group-hover:scale-105 transition-all">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <h4 class="font-bold text-lg text-neutral-900">Nouveau Bien</h4>
                                <p class="text-sm text-neutral-600 mt-1">Ajouter à catalogue</p>
                            </div>
                        </Link>

                        <Link
                            :href="route('admin.inquiries.index')"
                            class="group flex flex-col items-center gap-3 rounded-2xl bg-white p-6 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border hover:border-blue-300"
                        >
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-xl group-hover:shadow-blue-500/25 group-hover:scale-105 transition-all">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <h4 class="font-bold text-lg text-neutral-900">Leads</h4>
                                <p class="text-sm text-neutral-600 mt-1">{{ props.stats?.inquiries ?? 0 }} nouveaux</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
