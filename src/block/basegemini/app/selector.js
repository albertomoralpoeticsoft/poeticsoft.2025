import { createSelector } from '@reduxjs/toolkit';

const selectCounterState = (state) => state.geminiApi;

export const selectGeminiApi = createSelector(
  selectCounterState,
  (geminiApi) => geminiApi
)