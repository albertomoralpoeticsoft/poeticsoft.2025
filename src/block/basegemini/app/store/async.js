import { 
  createApi, 
  fetchBaseQuery 
} from '@reduxjs/toolkit/query/react';

export const geminiApi = createApi({
  reducerPath: 'geminiApi',
  baseQuery: fetchBaseQuery({ 
    baseUrl: '/wp-json/poeticsoft/gemini/' 
  }),
  endpoints: (builder) => ({
    getModelByName: builder.query({
      query: (name) => `${ name }`,
    }),
    getModels: builder.query({
      query: () => 'models',
    }),
  }),
});

export const { 
  useGetModelByNameQuery,
  useLazyGetModelByNameQuery,
  useGetModelsQuery,
  useLazyGetModelsQuery
} = geminiApi;