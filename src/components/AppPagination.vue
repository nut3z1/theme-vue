<template>
  <div v-if="shouldShow" class="flex items-center justify-center gap-2 mt-12">

    <!-- Prev button -->
    <button
      @click="onPrev"
      :disabled="!canPrev || disabled"
      class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30 disabled:cursor-not-allowed"
      aria-label="Trang trước"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </button>

    <!-- Numbered pages (mode = 'pages') -->
    <template v-if="mode === 'pages'">
      <template v-for="item in pages" :key="item">
        <button
          v-if="item !== '...'"
          @click="onPage(item)"
          :disabled="disabled"
          class="min-w-[40px] h-10 px-3 rounded-xl text-sm font-medium transition-all disabled:cursor-not-allowed"
          :class="item === modelValue
            ? 'bg-primary-500 text-white shadow-glow'
            : 'border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400'"
        >
          {{ item }}
        </button>
        <span v-else class="px-2 text-dark-500 select-none">…</span>
      </template>
    </template>

    <!-- Token-based label (mode = 'token') -->
    <span v-else class="px-3 text-sm text-dark-400 select-none">
      Trang {{ currentTokenPage }}
    </span>

    <!-- Next button -->
    <button
      @click="onNext"
      :disabled="!canNext || disabled"
      class="p-2.5 rounded-xl border border-dark-700 text-dark-400 hover:border-primary-500/50 hover:text-primary-400 transition-all disabled:opacity-30 disabled:cursor-not-allowed"
      aria-label="Trang sau"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
    </button>

  </div>
</template>

<script setup>
import { computed, ref } from 'vue';

/**
 * AppPagination — shared pagination component
 *
 * Props for numbered mode (mode="pages"):
 *   modelValue   {number}  current page (v-model)
 *   totalPages   {number}  total number of pages
 *
 * Props for token mode (mode="token"):
 *   hasNext      {boolean} whether next page token exists
 *   hasPrev      {boolean} whether prev page token exists
 *
 * Common props:
 *   mode         {'pages'|'token'}  default: 'pages'
 *   disabled     {boolean}          disable all buttons (e.g. while loading)
 *
 * Emits:
 *   update:modelValue(page)  — numbered mode page change
 *   prev                     — token mode prev clicked
 *   next                     — token mode next clicked
 */
const props = defineProps({
  mode: {
    type: String,
    default: 'pages',
    validator: (v) => ['pages', 'token'].includes(v),
  },
  // numbered mode
  modelValue: { type: Number, default: 1 },
  totalPages:  { type: Number, default: 0 },
  // token mode
  hasNext: { type: Boolean, default: false },
  hasPrev: { type: Boolean, default: false },
  // shared
  disabled: { type: Boolean, default: false },
});

const emit = defineEmits(['update:modelValue', 'prev', 'next']);

// Internal page counter for token mode (display only)
const currentTokenPage = ref(1);

// ------- visibility -------
const shouldShow = computed(() => {
  if (props.mode === 'pages') return props.totalPages > 1;
  return props.hasNext || props.hasPrev;
});

// ------- numbered mode -------
const canPrev = computed(() =>
  props.mode === 'pages' ? props.modelValue > 1 : props.hasPrev
);
const canNext = computed(() =>
  props.mode === 'pages' ? props.modelValue < props.totalPages : props.hasNext
);

/**
 * Smart ellipsis page list — always shows first, last,
 * current ±1, and fills with '...' gaps.
 */
const pages = computed(() => {
  const total = props.totalPages;
  const current = props.modelValue;
  const result = [];

  if (total <= 7) {
    for (let i = 1; i <= total; i++) result.push(i);
    return result;
  }

  result.push(1);
  if (current > 3) result.push('...');

  const start = Math.max(2, current - 1);
  const end   = Math.min(total - 1, current + 1);
  for (let i = start; i <= end; i++) result.push(i);

  if (current < total - 2) result.push('...');
  result.push(total);

  return result;
});

// ------- handlers -------
function onPage(page) {
  if (page === props.modelValue || props.disabled) return;
  emit('update:modelValue', page);
}

function onPrev() {
  if (props.disabled) return;
  if (props.mode === 'pages') {
    if (props.modelValue > 1) emit('update:modelValue', props.modelValue - 1);
  } else {
    currentTokenPage.value = Math.max(1, currentTokenPage.value - 1);
    emit('prev');
  }
}

function onNext() {
  if (props.disabled) return;
  if (props.mode === 'pages') {
    if (props.modelValue < props.totalPages) emit('update:modelValue', props.modelValue + 1);
  } else {
    currentTokenPage.value += 1;
    emit('next');
  }
}

// Reset token page counter when component resets to start
function resetTokenPage() {
  currentTokenPage.value = 1;
}

defineExpose({ resetTokenPage });
</script>
