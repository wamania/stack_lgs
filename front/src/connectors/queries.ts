import gql from 'graphql-tag';

export const SUPPLIERS_QUERY = gql`
query Suppliers{
    suppliers{
      id
      code
      name
      products{
        id
        name
        reference
        variants{
          sku
          color
          price
        }
      }
    }
  }
`