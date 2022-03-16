import { gql } from '@apollo/client';
import * as Apollo from '@apollo/client';
export type Maybe<T> = T | null;
export type InputMaybe<T> = Maybe<T>;
export type Exact<T extends { [key: string]: unknown }> = { [K in keyof T]: T[K] };
export type MakeOptional<T, K extends keyof T> = Omit<T, K> & { [SubKey in K]?: Maybe<T[SubKey]> };
export type MakeMaybe<T, K extends keyof T> = Omit<T, K> & { [SubKey in K]: Maybe<T[SubKey]> };
const defaultOptions = {} as const;
/** All built-in and custom scalars, mapped to their actual values */
export type Scalars = {
  ID: string;
  String: string;
  Boolean: boolean;
  Int: number;
  Float: number;
};

export enum CurrencyEnum {
  Eur = 'EUR',
  Jpy = 'JPY',
  Usd = 'USD',
  Xpf = 'XPF'
}

export type Mutation = {
  __typename?: 'Mutation';
  /**
   *
   *
   */
  saveProduct: Product;
};


export type MutationSaveProductArgs = {
  product: ProductInput;
};

export type Product = {
  __typename?: 'Product';
  /**
   *
   *
   */
  id?: Maybe<Scalars['Int']>;
  /**
   *
   *
   */
  name?: Maybe<Scalars['String']>;
  /**
   *
   *
   */
  reference?: Maybe<Scalars['String']>;
  /**
   *
   *
   */
  supplier?: Maybe<Supplier>;
  /**
   *
   *
   */
  variants: Array<Variant>;
};

export type ProductInput = {
  name?: InputMaybe<Scalars['String']>;
  reference: Scalars['String'];
  supplier?: InputMaybe<SupplierInput>;
};

export type Query = {
  __typename?: 'Query';
  /**
   *
   *
   */
  suppliers: Array<Supplier>;
};


export type QuerySuppliersArgs = {
  reference?: InputMaybe<Scalars['String']>;
  sku?: InputMaybe<Scalars['String']>;
};

export type Supplier = {
  __typename?: 'Supplier';
  /**
   *
   *
   */
  code?: Maybe<Scalars['String']>;
  /**
   *
   *
   */
  id?: Maybe<Scalars['Int']>;
  /**
   *
   *
   */
  name?: Maybe<Scalars['String']>;
  /**
   *
   *
   */
  products: Array<Product>;
};

export type SupplierInput = {
  code: Scalars['String'];
};

export type Variant = {
  __typename?: 'Variant';
  color?: Maybe<Scalars['String']>;
  /**
   *
   *
   */
  convertPrice: Scalars['Float'];
  id?: Maybe<Scalars['ID']>;
  price?: Maybe<Scalars['Float']>;
  product?: Maybe<Product>;
  sku?: Maybe<Scalars['String']>;
};


export type VariantConvertPriceArgs = {
  to: CurrencyEnum;
};

export type SuppliersQueryVariables = Exact<{ [key: string]: never; }>;


export type SuppliersQuery = { __typename?: 'Query', suppliers: Array<{ __typename?: 'Supplier', id?: number | null, code?: string | null, name?: string | null, products: Array<{ __typename?: 'Product', id?: number | null, name?: string | null, reference?: string | null, variants: Array<{ __typename?: 'Variant', sku?: string | null, color?: string | null, price?: number | null }> }> }> };


export const SuppliersDocument = gql`
    query Suppliers {
  suppliers {
    id
    code
    name
    products {
      id
      name
      reference
      variants {
        sku
        color
        price
      }
    }
  }
}
    `;

/**
 * __useSuppliersQuery__
 *
 * To run a query within a React component, call `useSuppliersQuery` and pass it any options that fit your needs.
 * When your component renders, `useSuppliersQuery` returns an object from Apollo Client that contains loading, error, and data properties
 * you can use to render your UI.
 *
 * @param baseOptions options that will be passed into the query, supported options are listed on: https://www.apollographql.com/docs/react/api/react-hooks/#options;
 *
 * @example
 * const { data, loading, error } = useSuppliersQuery({
 *   variables: {
 *   },
 * });
 */
export function useSuppliersQuery(baseOptions?: Apollo.QueryHookOptions<SuppliersQuery, SuppliersQueryVariables>) {
        const options = {...defaultOptions, ...baseOptions}
        return Apollo.useQuery<SuppliersQuery, SuppliersQueryVariables>(SuppliersDocument, options);
      }
export function useSuppliersLazyQuery(baseOptions?: Apollo.LazyQueryHookOptions<SuppliersQuery, SuppliersQueryVariables>) {
          const options = {...defaultOptions, ...baseOptions}
          return Apollo.useLazyQuery<SuppliersQuery, SuppliersQueryVariables>(SuppliersDocument, options);
        }
export type SuppliersQueryHookResult = ReturnType<typeof useSuppliersQuery>;
export type SuppliersLazyQueryHookResult = ReturnType<typeof useSuppliersLazyQuery>;
export type SuppliersQueryResult = Apollo.QueryResult<SuppliersQuery, SuppliersQueryVariables>;
export function refetchSuppliersQuery(variables?: SuppliersQueryVariables) {
      return { query: SuppliersDocument, variables: variables }
    }