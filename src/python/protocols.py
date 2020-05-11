import os
import rhapsody as rd


FIGURE_MAX_WIDTH = 100


# define Rhapsody keyword arguments
kwargs = {}
# read configuration file
config = {}
with open('config.txt', 'r') as f:
    for line in f:
        key, value = line.split(':')
        config[key.strip()] = value.strip()
# use full+EVmutation classifier?
if config.get('include EVmutation feature') == 'True':
    kwargs['main_classifier'] = rd.getDefaultClassifiers()['EVmut']
    kwargs['aux_classifier'] = rd.getDefaultClassifiers()['reduced']
# use sliced ANM?
if config.get('include environmental effects') == 'True':
    kwargs['force_env'] = 'sliced'
# others...
for i, step in enumerate(['Uniprot', 'PDB', 'Pfam']):
    kwargs[f'status_file_{step}'] = f'rhapsody-status.txt'
    kwargs[f'status_prefix_{step}'] = f'STEP {i+1}: '


def sat_mutagen():

    # import data
    with open('input-sm_query.txt', 'r') as f:
        input_query = f.read().strip()
    if os.path.isfile('input-PDBID.txt'):
        with open('input-PDBID.txt', 'r') as f:
            pdb = f.read()
    elif os.path.isfile('input-PDB.pdb'):
        pdb = 'input-PDB.pdb'
    elif os.path.isfile('input-PDB.pdb.gz'):
        pdb = 'input-PDB.pdb.gz'
    else:
        pdb = None

    # run RHAPSODY
    if os.path.isfile('pph2-full.txt'):
        rh = rd.rhapsody('pph2-full.txt', query_type='PolyPhen2',
                         custom_PDB=pdb, log=False, **kwargs)
    else:
        rh = rd.rhapsody(input_query, custom_PDB=pdb, log=False, **kwargs)

    # write predictions on PDB file(s)
    rh.writePDBs()

    # create figure(s)
    num_res = int(rh.numSAVs/19)
    if num_res <= FIGURE_MAX_WIDTH:
        rd.print_sat_mutagen_figure('rhapsody-figure.png', rh, html=True,
                                    main_clsf='full', aux_clsf='reduced')
    else:
        num_splits = int(num_res/FIGURE_MAX_WIDTH) + 1
        n = int(num_res/num_splits)
        remainder = num_res % num_splits
        for i in range(num_splits):
            dr = (i*n + 1, (i + 1)*n + remainder)
            fname = f'rhapsody-figure_{i + 1}.png'
            rd.print_sat_mutagen_figure(fname, rh, res_interval=dr, html=True,
                                        main_clsf='full', aux_clsf='reduced')

    return rh


def batch_query():

    # run RHAPSODY
    if os.path.isfile('pph2-full.txt'):
        rh = rd.rhapsody(
            'pph2-full.txt', query_type='PolyPhen2', log=False, **kwargs)
    else:
        rh = rd.rhapsody('input-batch_query.txt', log=False, **kwargs)

    return rh
