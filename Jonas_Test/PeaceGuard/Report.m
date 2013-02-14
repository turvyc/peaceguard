//
//  Report.m
//  PeaceGuard
//
//  Created by JonasYao on 2013-02-13.
//  Copyright (c) 2013 JonasYao. All rights reserved.
//

#import "Report.h"

@implementation Report

-(id) initWithName:(NSString *)title description:(NSString *)description{
    self = [super init];
    if(self) {
        _title = title;
        _description = description;
        return self;
    }
    
    return nil;
    
}
@end
