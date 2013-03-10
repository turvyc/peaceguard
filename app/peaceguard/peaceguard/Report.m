//
//  Report.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
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
