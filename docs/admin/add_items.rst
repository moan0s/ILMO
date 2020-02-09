Add Items to lend
=================

In the current state ILMO only supports one indexing system for books
and one for material. If you have an existing numbering system it is advised
to reach out to a developer to see if the system can be added or to adapt
the supported indexing system.

Books
-----

ID System
^^^^^^^^^

As most libraries do often have multiple copies of the same book an identification
system was found that accounts for that. 

For books the ID format therefore consists of a ``stem`` of category and 
number and a ``numbering`` with characters of copies.

.. code::

   CC[number] [ii]
   
   "CH42 c"    # Titel 42 in category Chemistry, copy number 3

   "XY132 af"  # Titel 132 in category XY, copy number 33

   "a16792 c"  # bad example as categories should be two capital letters and the
               # titel number should be ascending

- CC: 
   Category abbreviation e. ``CH`` for chemistry. It is advised to use
   a two letter abbreviation, but there is no technical limit.
- Number: 
   Indicates which title the book has. The number is ascending incremented for every title
   added to the category.
- ii: 
   index of the copy. For the first copy the index is ``a`` for the second 
   it is ``b`` and for the 27th copy it is ``aa``.

Adding books
^^^^^^^^^^^^

When adding books to the library you have to provide the following:

- Book-ID:
   * You add only one book to the library:
      Give a full ID e.g. ``CH4 a`` and no number or the number one.
   * You add multiple books to the library:
      Give only an ID stem. The index of the copy will be added automatically.
- Number of copies
- Title
- Author [optional]
- Location [optional]

Give all of that information and click send.

Material
--------

ID System
^^^^^^^^^

Material has a different ID system. It consists of an abbreviation and an index.

.. code::

   AA [index]
   
   "LC 42"           # Labcoat number 42
   "SG 132"          # Safety glasses number 132

   "Labcoat 16792"   # bad example as abbreviation should be two capital letters and index
                     # number should be ascending

- AA:
   Abbreviation of the items name
- Index:
   Ascending number. The highest index of an item is the number of items of this name.

Adding Material
^^^^^^^^^^^^^^^

To add material add provide the following:

- Material abbreviation
- Number of items to add
- Name of the item type [e.g. Labcoat]
- Location [optional]

Give all of that information and click send.
