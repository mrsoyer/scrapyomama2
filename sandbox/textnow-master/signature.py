import md5

class generate(object):
    def __init__(self, *args, **kwargs):
        return

    def signature(self, *args, **kwargs):
        self.md5 = md5.new(
                '%s%s%s%s'%(
                        'f8ab2ceca9163724b6d126aea9620339',
                        kwargs['method'],
                        kwargs['url'],
                        kwargs['json'],
                    )
            )
        return self.md5.hexdigest()

if __name__ == "__main__":
    print("You don't run this.")